@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search...">
        </div>
    </div>
    <div class="row">
        @foreach($products as $product)
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
        @endforeach
        {{ $products->links() }}
    </div>
</div>


<script>
    $(document).ready(function(){
        let inputAppended = false;
        $(".span_order").click(function (e){
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
        })
    })
</script>
@endsection
