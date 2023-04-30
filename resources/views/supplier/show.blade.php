@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <img
                            src="{{ $supplier->image ?? 'https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/39361/shirt-clipart-md.png' }}"
                            style="width: 100px;"
                        >
                        <div
                            style="height: 20px; position:absolute; right: 1%;"
                        >

                        </div>
                    </div>
                    <div class="card-body">
                        <p class="product-name">{{ $supplier->name }}</p>
                        <p class="product-price">{{ $supplier->price }}</p>
                        <p class="product-quantity">{{ $supplier->quantity }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-success">Show</a>

                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
