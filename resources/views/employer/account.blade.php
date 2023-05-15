@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{-- $data --}}
            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-body">
                        <p>Hello {{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
