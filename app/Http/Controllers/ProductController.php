<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\RequestProduct;
use Elastic\Elasticsearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Ignition\Tests\TestClasses\Models\Car;
use Session;
use Stripe;
use Illuminate\Support\Facades\Redis;
use function Webmozart\Assert\Tests\StaticAnalysis\uuid;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::whereStatus(1)->orderByDesc('created_at');
        if (!is_null($request->search)) {
            return $this->search($products, $request->search);
        }
        $products = $products->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        $productCart = Cart::where('product_id', $product->id)->first();
        return redirect()->route('admin.dashboard');
//        return view('product.show', compact('product', 'productCart'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $productCart = Cart::where('product_id', $product->id)->first();
        return view('product.show', compact('product', 'productCart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('admin.dashboard');
//        return view('product.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }

    public function toggleButtonToCart(Product $product, Request $request)
    {
        $productCart = Cart::where('product_id', $product->id);
        $user = Auth::user();
        if (!$productCart->first())
        {
            Cart::create(
                [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $request->quantity ?? 1,
                    'price' => $product->price ,
                ]);
        } else {
            $productCart->delete();
        }
        return redirect()->back();
    }

    public function increaseQuantity(Product $product, Request $request)
    {
        $product->increment('quantity', $request->quantity);
        return redirect()->back();
    }

    public function decreaseQuantity(Product $product, $quantity)
    {
        $product->decrement('quantity', $quantity);
        return redirect()->back();
    }

    public function buyProduct(Product $product, Request $request)
    {
        $quantity = $request->quantity ?? 1;
        if ($quantity > $product->quantity) {
            return redirect()->back();
        }
        $user = Auth::user();
        Redis::set($user->id.":".$product->id.":order_quantity", $quantity);

        return view('checkout.v1', compact('product'));
    }

    public function buyMultipleProduct(Request $request)
    {
        $inputs = $request->all();
        $user = Auth::user();
        unset($inputs['_token']);
        $price = 0;
        foreach ($inputs as $key => $input)
        {
            $price += $input['price'] * $input['quantity'];
            try {
                $cart = Cart::where('user_id', $user->id)->where('product_id', $input['product_id'])->update(['quantity' => $input['quantity'], 'price' => $input['price'] * $input['quantity']]);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
            Redis::set($user->id.":".$input['product_id'].":order_quantity", $input['quantity']);
        }

        return view('checkout.multiple_v1', compact('inputs', 'price'));
    }

    public function checkoutStripe(Product $product, Request $request)
    {
        $user = Auth::user();
        $orderQuantity = Redis::get("$user->id:$product->id:order_quantity");
        Redis::del("$user->id:$product->id:order_quantity");
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = Auth::user();
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1" => "Virani Chowk",
                "postal_code" => "360001",
                "city" => "Rajkot",
                "state" => "GJ",
                "country" => "IN",
            ],
            "email" => $user->email,
            "name" => $user->name,
            "source" => $request->stripeToken
        ));
        $buyStatus = Stripe\Charge::create ([
            "amount" => $orderQuantity * $product->price * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Test payment from. ",
            "shipping" => [
                "name" => $product->name,
                "address" => [
                    "line1" => "510 Townsend St",
                    "postal_code" => "98140",
                    "city" => "San Francisco",
                    "state" => "CA",
                    "country" => "US",
                ],
            ]
        ]);
        Session::flash('success', 'Payment successful!');
        Cart::where('product_id', $product->id)->delete();
        if (!is_null($buyStatus->id)) {
            $this->decreaseQuantity($product, $orderQuantity);
            Order::create(
                [
                    "order_number" => $buyStatus->id,
                    "product_id" => $product->id,
                    "user_id" => $user->id,
                    "status" => $buyStatus->status == 'succeeded' ? 1 : 0,
                    "quantity" => 1,
                    "price" =>  $product->price,
                    "delivery_data" => [
                        'receipt_url' => $buyStatus->receipt_url,
                    ],
                ]);
        }
        return redirect()->route('cart.index');
    }

    public function checkoutMultipleStripe(Request $request)
    {
        /*******************/
        /*******************/
        /* CREATE CUSTOMER */
        /*******************/
        /*******************/


        $user = Auth::user();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $userCart = Cart::where('user_id', $user->id);
        $productsIdInCarts = $userCart->pluck('product_id')->toArray();
        $amount = $userCart->pluck('price')->toArray();
        $buyStatus = Stripe\Charge::create([
            'amount' => array_sum($amount) * 100,
            'currency' => 'usd',
            'source' => $request->input('stripeToken'),
            'description' => 'Payment for multiple products',
        ]);
        $userCartData = $userCart->get();

        if (!is_null($buyStatus->id)) {
            foreach ($userCartData as $cartData)
            {
                $product = Product::find($cartData->product_id);
                $this->decreaseQuantity($product, $cartData->quantity);
                Order::create(
                [
                    "order_number" => $buyStatus->id,
                    "product_id" => $product->id,
                    "user_id" => $user->id,
                    "status" => $buyStatus->status == 'succeeded' ? 1 : 0,
                    "quantity" => $cartData->quantity,
                    "price" =>  $product->price * $cartData->quantity,
                    "delivery_data" => [
                        'receipt_url' => $buyStatus->receipt_url,
                    ],
                ]);
            }
            $userCart->whereIn('product_id', $productsIdInCarts)->delete();
        }
        return redirect()->route('cart.index');

    }

    public function changeStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
        return redirect()->back();
    }

    public function orderNewProduct(Product $product, Request $request)
    {
        $user = Auth::user();
        RequestProduct::create(
            [
                'product_id' => $product->id,
                'user_id' => $user->id,
                'quantity' => $request->order_quantity,
            ]);
        return redirect()->back();
    }

    public function orderConfirm(RequestProduct $requestProduct)
    {
        $requestProduct->update(['status' => 1]);

        $requestProduct->product->increment('quantity', $requestProduct->quantity);
        return redirect()->back();
    }

    public function orderReject(RequestProduct $requestProduct)
    {
        $requestProduct->delete();
        return redirect()->back();
    }

    public function getProductsJson(Request $request)
    {
        $products = Product::whereStatus(1)->orderByDesc('created_at');
        if (!is_null($request->search)) {
            return $this->search($products, $request->search);
        }
        $products = $products->paginate(20);

        return response()->json($products);
    }

    public function search($query, $search)
    {
        return response()->json($query->where('name', 'LIKE', "%$search%")->paginate(20));
    }

}
