@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#transactions">Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#users">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#products">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sell">Sell</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#request">Request Product</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="transactions">
                <h2>My Transactions</h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Receipt</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->order_number }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td>{{ $transaction->status == 1 ? 'Success' : 'Failed' }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->price }}</td>
                            <td>
                                <a href="{{ $transaction->delivery_data['receipt_url'] }}" target="_blank" download>
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="users">
                <h2>Users</h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Verficated</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Admin' : 'Member' }}</td>
                            <td>{{ $user->email_verified_at == NULL ? '-' : $user->email_verified_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="products">
                <h2>Products <a href="{{ route('product.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qnt.</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->status == 1 ? 'Active' : 'Deactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('product.toggle.status', $product) }}" class="btn btn-outline-dark col-md-3 mr-2"><i class="fa fa-refresh"></i> {{ $product->status == 1 ? "Deactivate" : "Activate" }}</a>
                                    <a href="{{ route('product.edit', $product) }}" class="btn btn-outline-warning mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="{{ route('product.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="sell">
                <h2>Sell</h2>

                <p>This is where you can sell products.</p>
            </div>

            <div class="tab-pane fade" id="request">
                <h2>Request Product</h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Order Quantity</th>
                        <th>User name</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requestedProducts as $requestedProduct)
                        <tr>
                            <td>{{ $requestedProduct->product->name }}</td>
                            <td>{{ $requestedProduct->quantity }}</td>
                            <td>{{ $requestedProduct->user->name }}</td>
                            <td>
                                <a href="{{ route('product.order.confirm', $requestedProduct) }}" class="btn btn-outline-success">Confirm</a>
                                <a href="{{ route('product.order.reject', $requestedProduct) }}" class="btn btn-outline-danger">Reject</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
