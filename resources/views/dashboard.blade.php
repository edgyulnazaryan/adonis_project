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
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#resources">Resources</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#supplier">Suppliers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#employer">Employers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#positions">Positions</a>
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

            <div class="tab-pane fade" id="resources">
                <h2>Resource <a href="{{ route('resources.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Qnt.</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resources as $resource)
                        <tr>
                            <td>{{ $resource->name }}</td>
                            <td>{{ $resource->price }}</td>
                            <td>{{ $resource->currency }}</td>
                            <td>{{ $resource->quantity }} {{ $resource->unit_measurement }}</td>
                            <td>{{ $resource->status == 1 ? 'Active' : 'Deactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('resources.toggle.status', $resource) }}" class="btn btn-outline-dark col-md-3 mr-2"><i class="fa fa-refresh"></i> {{ $resource->status == 1 ? "Deactivate" : "Activate" }}</a>
                                    <a href="{{ route('resources.edit', $resource) }}" class="btn btn-outline-warning mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="{{ route('resources.destroy', $resource) }}" method="POST">
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

            <div class="tab-pane fade" id="supplier">
                <h2>Supplier <a href="{{ route('supplier.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->surname }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->balance }}</td>
                            <td>{{ $supplier->status == 1 ? 'Active' : 'Deactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('supplier.toggle.status', $supplier) }}" class="btn btn-outline-dark col-md-3 mr-2"><i class="fa fa-refresh"></i> {{ $supplier->status == 1 ? "Deactivate" : "Activate" }}</a>
                                    <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-outline-warning mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-outline-info mr-2"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('supplier.destroy', $supplier) }}" method="POST">
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

            <div class="tab-pane fade" id="employer">
                <h2>Employer <a href="{{ route('employer.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Balance</th>
                        <th>Date of Birth</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employers as $employer)
                        <tr>
                            <td>{{ $employer->name }}</td>
                            <td>{{ $employer->surname }}</td>
                            <td>{{ $employer->phone }}</td>
                            <td>{{ $employer->address }}</td>
                            <td>{{ $employer->salary }}</td>
                            <td>{{ $employer->balance }}</td>
                            <td>{{ $employer->date_of_birth }}</td>
                            <td>{{ $employer->status == 1 ? 'Active' : 'Deactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('employer.toggle.status', $employer) }}" class="btn btn-outline-dark col-md-4 mr-2"><i class="fa fa-refresh"></i> {{ $employer->status == 1 ? "Deactivate" : "Activate" }}</a>
                                    <a href="{{ route('employer.edit', $employer) }}" class="btn btn-outline-dark mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('employer.show', $employer) }}" class="btn btn-outline-dark mr-2"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('employer.destroy', $employer) }}" method="POST">
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

            <div class="tab-pane fade" id="positions">
                <h2>Position <a href="{{ route('position.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($positions as $position)
                        <tr class="text-center" style="color:#1a202c; cursor: pointer; background-color:{{ $position->is_online ? 'rgba(92,188,130,0.5)' : '' }}">
                            <td>{{ $position->name }}</td>
                            <td>{{ $position->status == 1 ? 'Active' : 'Deactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('position.toggle.status', $position) }}" class="btn btn-outline-dark col-md-3 mr-2"><i class="fa fa-refresh"></i> {{ $position->status == 1 ? "Deactivate" : "Activate" }}</a>
                                    <a href="{{ route('position.edit', $position) }}" class="btn btn-outline-dark mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="{{ route('position.destroy', $position) }}" method="POST">
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
        </div>
    </div>
@endsection
