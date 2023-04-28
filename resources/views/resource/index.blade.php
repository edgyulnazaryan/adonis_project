@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <input type="text" name="search" id="search_input" class="form-control" placeholder="Search...">
        </div>
    </div>
    <div class="row search-result">

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
        let inputAppended = false;
        let search = null
        let image_src = null
        let token = $('input[name="_token"]').val();
        searchProducts(search)

        function searchProducts(search) {
            $('#loader').show();
            $(".search-result").html('')
            let dataHtml = ''
            $.ajax({
                url: "/admin/resources/all",
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data : {'search' : search},
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
                            image_src = 'https://img.icons8.com/?size=512&id=zU4mwUBuKSXl&format=png'
                        } else {
                            image_src = response.data[i].image
                        }
                        dataHtml += `
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

                                </div>
                            </div>
                            `
                        $(".search-result").html(
                            dataHtml
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

        $("#search_input").on("input", function (e){
            search = e.target.value
            searchProducts(search)
        })
    })

</script>
@endsection
