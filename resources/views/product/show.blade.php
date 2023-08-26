@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <img
                            src="{{ $product->image ?? 'https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/39361/shirt-clipart-md.png' }}"
                            style="width: 100px;"
                        >
                        <div
                            style="height: 20px; position:absolute; right: 1%;"
                        >
                            @if(is_null($productCart))
                                <a href="{{ route('product.toggle_cart', $product) }}" class="btn btn-success">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"> Add to Cart</i>
                                </a>
                            @else
                                <a href="{{ route('product.toggle_cart', $product) }}" class="btn btn-success">
                                    <i class="fa fa-check" aria-hidden="true">Added !</i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">

                        <p class="product-name">{{ $product->name }}</p>
                        <p class="product-price">{{ $product->price }}</p>
                        <p class="product-quantity">{{ $product->quantity }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
