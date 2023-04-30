@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h3>{{ $supplier->name }} {{ $supplier->surname }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="supplier-balance">
                            <span><strong>Balance : </strong></span>
                            {{ $supplier->balance }}
                        </p>
                        <p class="supplier-phone">
                            <span><strong>Phone : </strong></span>
                            {{ $supplier->phone }}
                            <span><a href="tel:{{ $supplier->phone }}"><i class="fa fa-phone"></i></a></span>
                        </p>
                        <p class="supplier-external-phone">
                            <span><strong>External Phone : </strong></span>
                            {{ $supplier->external_phone }}
                            <span><a href="tel:{{ $supplier->external_phone }}"><i class="fa fa-phone"></i></a></span>
                        </p>
                        <p class="supplier-address">
                            <span><strong>Address : </strong></span>
                            {{ $supplier->address }}
                        </p>
                        <p class="supplier-external-address">
                            <span><strong>External Address : </strong></span>
                            {{ $supplier->external_address }}
                        </p>
                        <p class="supplier-coupon">
                            <span><strong>Coupon code : </strong></span>
                            {{ $supplier->coupon }}
                        </p>
                        <p class="supplier-note">
                            <span><strong>Note : </strong></span>
                            {{ $supplier->note }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('supplier.destroy', $supplier) }}" class="btn btn-danger">Delete supplier</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
