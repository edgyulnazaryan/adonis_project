@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mt-3">
                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-outline-success h-100 btn-group-vertical">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h3>{{ $employer->name }} {{ $employer->surname }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="employer-balance">
                            <span><strong>Balance : </strong></span>
                            {{ $employer->balance }}
                        </p>
                        <p class="employer-salary">
                            <span><strong>Salary : </strong></span>
                            {{ $employer->salary }}
                        </p>
                        <p class="employer-phone">
                            <span><strong>Phone : </strong></span>
                            {{ $employer->phone }}
                            <span><a href="tel:{{ $employer->phone }}"><i class="fa fa-phone"></i></a></span>
                        </p>
                        <p class="employer-external-phone">
                            <span><strong>External Phone : </strong></span>
                            {{ $employer->external_phone }}
                            <span><a href="tel:{{ $employer->external_phone }}"><i class="fa fa-phone"></i></a></span>
                        </p>
                        <p class="employer-address">
                            <span><strong>Address : </strong></span>
                            {{ $employer->address }}
                        </p>
                        <p class="employer-date-of-birth">
                            <span><strong>Date of Birth : </strong></span>
                            {{ $employer->date_of_birth }}
                        </p>
                        <p class="employer-coupon">
                            <span><strong>Coupon code : </strong></span>
                            {{ $employer->coupon }}
                        </p>
                        <p class="employer-note">
                            <span><strong>Note : </strong></span>
                            {{ $employer->note }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('employer.edit', $employer) }}" class="btn btn-warning mr-2 text-white"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{ route('employer.destroy', $employer) }}" class="btn btn-danger">Delete employer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
