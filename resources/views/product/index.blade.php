@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('product.filter') }}" method="GET">
                <h3>Size</h3>
                <div class="d-flex">
                    <div class="col-md-6">
                        <div class="form-group mt-3 d-flex align-items-center">
                            <input class="form-control col-md-4" type="number" name="priceMin" id="minPriceValue" placeholder="Min price">
                        </div>

                        <div class="form-group mt-3 d-flex align-items-center">
                            <input class="form-control col-md-4" type="number" name="priceMax" id="maxPriceValue" placeholder="Max price">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mt-3 d-flex align-items-center">
                            <input class="form-control col-md-4" type="number" name="qntMin" id="minQntValue" placeholder="Min quantity">
                        </div>

                        <div class="form-group mt-3 d-flex align-items-center">
                            <input class="form-control col-md-4" type="number" name="qntMax" id="maxQntValue" placeholder="Max quantity">
                        </div>
                    </div>
                </div>



                <button type="button" class="btn btn-outline-dark btn-block mt-3" id="filterProductsBtn">Filter</button>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <input type="text" name="search" id="search_input" class="form-control" placeholder="Search...">
        </div>
    </div>
    <div class="row search-result">
        <!-- Render initial search results here -->
        @include('partials.search-results', ['products' => $products])
    </div>
{{--    <div class="row search-result d-none"></div>--}}
    <div class="row product_data">
        {{--@foreach($products as $product)
            <div class="col-md-4 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <img
                            src="{{ $product->image ?? 'https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/39361/shirt-clipart-md.png' }}"
                            style="width: 100px;"
                        >
                    </div>
                    <div class="card-body">
                        <p class="product-name">Name : {{ $product->name }}</p>
                        <p class="product-price">Price : {{ $product->price }}</p>
                        <p class="product-quantity">Qnt. : {{ $product->quantity }}</p>
                        @if($product->quantity == 0)
                        <div class="d-flex">
                            <p class=""></p>
                            <form action="{{ route('product.request.order', $product) }}" method="POST">
                                @csrf
                                <span class="btn btn-primary badge badge-primary span_order" data-id="{{$product->id}}" type="submit">
                                    By Order
                                </span>
                                <input type="hidden" value="1" min="1" name="order_quantity" placeholder="Input quantity" class="form-control mt-2">
                                <input type="hidden" name="request_order_btn" class="btn btn-success mt-2 request_order_btn" value="Send order">
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('product.show', $product) }}" class="btn btn-success">Show</a>
                    </div>
                </div>
            </div>
        @endforeach--}}
        {{ $products->links() }}
    </div>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div id="loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
<style>
    .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        left: 50%;
        top: 150px;
    }
    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
    }
    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #de0a13;
        margin: -4px 0 0 -4px;
    }
    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }
    .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
    }
    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }
    .lds-roller div:nth-child(2):after {
        top: 68px;
        left: 56px;
    }
    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }
    .lds-roller div:nth-child(3):after {
        top: 71px;
        left: 48px;
    }
    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }
    .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
    }
    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }
    .lds-roller div:nth-child(5):after {
        top: 71px;
        left: 32px;
    }
    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }
    .lds-roller div:nth-child(6):after {
        top: 68px;
        left: 24px;
    }
    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }
    .lds-roller div:nth-child(7):after {
        top: 63px;
        left: 17px;
    }
    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }
    .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12px;
    }
    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>

<script>
    $(document).ready(function(){
        /*const socketApp = io.connect('http://192.168.224.162:3030');
        socketApp.on('cart', function (){
            console.log(1)
        })*/

        let inputAppended = false;
        let search = null
        let filter = null
        let image_src = null
        let token = $('input[name="_token"]').val();

        $("#search_input").on("input", function (e){
            search = e.target.value
            searchProducts(search, filter)
        })

        $("#filterProductsBtn").click(function (data){
            let minPriceValue = $("#minPriceValue").val();
            let maxPriceValue = $("#maxPriceValue").val();
            let minQnteValue = $("#minQnteValue").val();
            let maxQnteValue = $("#maxQnteValue").val();
            filter = {'priceMin' : minPriceValue, 'priceMax' : maxPriceValue, 'qntMin' : minQntValue, 'qntMax' : maxQntValue};
            searchProducts(search, filter)
        })
        searchProducts(search, filter)
        /*$(".span_order").click(function (e){
            let product_id = $(this).data('id');
            if(!inputAppended) {
                $(this).parent().children('input[name=order_quantity]').attr('type', 'number')
                $(this).parent().children('input[name=request_order_btn]').attr('type', 'submit')
                inputAppended = true
            } else {
                $(this).parent().children('input[name=order_quantity]').attr('type', 'hidden')
                $(this).parent().children('input[name=request_order_btn]').attr('type', 'hidden')
                inputAppended = false
            }
            console.log(inputAppended)
        })*/

        function searchProducts(search, filter) {
            $('#loader').show();
            $(".search-result").html('')
            $.ajax({
                url: "/products/all",
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data : {'search' : search, 'filter' : filter},
                success: function(response) {
                    $('#loader').show();
                    if (response.data.length == 0) {
                        $(".search-result").html(
                            `
                            <div class="col-md-12 mt-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h2>DATA NOT FOUND !</h2>
                                    </div>
                                </div>
                            </div>
                            `
                        )
                    }
                    for(let i=0; i<response.data.length; i++)
                    {
                        if (response.data[i].image == null) {
                            image_src = 'https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/39361/shirt-clipart-md.png'
                        } else {
                            image_src = '/images/'+response.data[i].image
                        }
                        let addCartStatus = response.data[i].cart_product_count ? 'Remove from Cart' : 'Add to Cart';
                        $(".search-result").append(
                            `
                            <div class="col-md-4 mt-3">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-center">
                                        <img
                                            src=${image_src}
                                            style="width: 100px;"
                                        >
                                    </div>
                                    <div class="card-body">
                                        <p class="product-name">Name : ${response.data[i].name}</p>
                                        <p class="product-price">Price : ${response.data[i].price}</p>
                                        <p class="product-quantity">Qnt. : ${response.data[i].quantity}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href='/product/${response.data[i].id}/cart' class="btn btn-outline-dark">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"> ${addCartStatus}</i>
                                        </a>
                                        <a href="/product/${response.data[i].id}" class="btn btn-success">Show</a>
<!--                                        <button class="addCart1" data-id="${response.data[i].id}">${addCartStatus}</button>-->
                                    </div>
                                </div>
                            </div>
                            `
                        )
                    }
                },
                complete: function() {
                    $('#loader').hide(); // Hide the loader when the request is complete
                },
                error: function(error) {
                    console.log(11, error);
                }
            })
        }


        $(".card").on('click', function (e) {
            alert(22)
        })
    })

</script>
@endsection
