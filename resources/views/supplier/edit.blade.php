@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Supplier') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('supplier.update', $supplier->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $supplier->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="surname">{{ __('Surname') }}</label>
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', $supplier->surname) }}" required autocomplete="surname" autofocus>
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $supplier->address, $supplier->address) }}" required autocomplete="address" autofocus>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="external_address">{{ __('External address') }}</label>
                                <input id="external_address" type="text" class="form-control @error('external_address') is-invalid @enderror" name="external_address" value="{{ old('external_address', $supplier->external_address) }}" required autocomplete="external_address" autofocus>
                                @error('external_address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">{{ __('Phone number') }}</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $supplier->phone) }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="external_phone">{{ __('External phone number') }}</label>
                                <input id="external_phone" type="tel" class="form-control @error('external_phone') is-invalid @enderror" name="external_phone" value="{{ old('external_phone', $supplier->external_phone) }}" required autocomplete="external_phone" autofocus>
                                @error('external_phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="balance">{{ __('Balance') }}</label>
                                <input id="balance" type="number" min="0" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $supplier->balance) ?? 0 }}" required autocomplete="balance" autofocus>
                                @error('balance')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="coupon">{{ __('Coupon') }}</label>
                                <input id="coupon" type="text" class="form-control @error('coupon') is-invalid @enderror" name="coupon" value="{{ old('coupon', $supplier->coupon) }}" required autocomplete="coupon" autofocus>
                                @error('coupon')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ old('note', $supplier->note) }}" required>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
