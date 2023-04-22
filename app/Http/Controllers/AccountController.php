<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\RequestProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $transactions = $this->getTransactions($user);

        if($user->is_admin) {
            $users = $this->getUsers();
            $products = $this->getProducts();
            $requestedProducts = $this->getRequestProducts();
            return view('dashboard', compact('transactions', 'users', 'products', 'requestedProducts'));
        }
        return view('user-dashboard', compact('transactions'));
    }

    public function getTransactions($user)
    {
        if (!$user->is_admin) {
            return Order::with('product')->where('user_id', $user->id)->orderByDesc('created_at')->get();
        }
        return Order::with('product')->orderByDesc('created_at')->get();
    }

    public function getUsers()
    {
        return User::orderByDesc('created_at')->get();
    }

    public function getProducts()
    {
        return Product::orderByDesc('created_at')->get();
    }

    public function getRequestProducts()
    {
        return RequestProduct::with('product', 'user')->where('status', 0)->get();
    }

    public function getNotification(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return RequestProduct::where('status', 0)->count();
        }
        return false;
    }
}
