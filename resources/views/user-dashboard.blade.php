@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#transactions">Orders</a>
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
        </div>
    </div>
@endsection
