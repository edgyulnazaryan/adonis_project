@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        @if(count($cartData) == 0)
            <h2>Cart is empty</h2>
        @else
        <input type="hidden" value="{{ count($cartData) }}" id="cartDataCount">
        <form action="{{ route('product.multi.buy') }}" class="order_form" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartData as $key => $data)
                    <tr>
                        <input type="hidden" name="{{$key}}[product_id]" value="{{ $data->product->id }}">
                        <input type="hidden" name="{{$key}}[price]" value="{{ $data->product->price }}">
                        <td>{{ $data->product->name }}</td>
                        <td>{{ $data->product->price }}</td>
                        <td class="col-md-2">
                            <input
                                type="number"
                                min="1"
                                placeholder="{{ $data->product->quantity }}"
                                max="{{ $data->product->quantity }}"
                                name="{{$key}}[quantity]"
                                class="form-control"
                                step="1"
                                id="order_quantity_{{$key}}"
                            >
                        </td>
                        <td>
                            <a href="{{ route('product.toggle_cart', $data->product) }}" class="btn btn-outline-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            {{--<a href="{{ route('product.buy', $data->product) }}" class="btn btn-outline-dark">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {{--<button class="btn btn-outline-dark btn_order" id="product_buy_btn_{{$key}}" data-id="{{ $key }}">
            <i class="fa fa-credit-card" aria-hidden="true"></i>
        </button>--}}
            <input type="submit" class="btn btn-outline-dark " value="Order">
        </form>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<div id="stripe_container"></div>

<script>
    $(document).ready(function (){
        /*jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        $(".order_form").validate({
            rules: {
                field: {
                    required: true,
                    maxlength: 4
                }
            }
        });*/

        /*$('input[type="number"]').on('input', function(e) {
            var value = $(this).val();
            var max = $(this).attr('max'); // get the maximum value from the input

            // Remove leading zeros
            value = value.replace(/^0+/, '');

            // Check for non-numeric characters and negative sign
            if (value.match(/[^0-9]/) || value.indexOf('-') !== -1) {
                value = value.replace(/[^0-9]/g, '');
                $(this).val(value);
                return;
            }

            // Check for less than 1
            if (value < 1) {
                $(this).val(1);
                return;
            }

            // Check for greater than the maximum value
            if (max !== undefined && value > max) {
                $(this).val(max);
                console.log($(this).val())
            }
            console.log("VALUE : "+ $(this).val())
            console.log("TYPE_OF : "+ $(this).val().type)
        });*/


        /*$(".btn_order").click(function (){
            let formNumber = $(this).data('id')
            try {
                $(".order_form_" + `${formNumber}`).submit();
            } catch (e) {
                console.log(e)
            }

                {{--let orderQuantity = $("#order_quantity").val();--}}
                {{--$.ajax(--}}
                {{--    {--}}
                {{--        url: "{{ route('product.buy', $data->product) }}",--}}
                {{--        method: 'GET',--}}
                {{--        dataType: 'json',--}}
                {{--        data : {'quantity' : orderQuantity},--}}
                {{--        success: function(response) {--}}

                {{--        },--}}
                {{--        error: function(error) {--}}
                {{--            // handle error response--}}
                {{--            console.log(error);--}}
                {{--        }--}}
                {{--    })--}}

        })*/
    })
</script>
@endsection
