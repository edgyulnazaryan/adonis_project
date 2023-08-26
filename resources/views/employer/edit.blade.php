@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Employer') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('employer.update', $employer->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $employer->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="surname">{{ __('Surname') }}</label>
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', $employer->surname) }}" required autocomplete="surname" autofocus>
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="surname">{{ __('Surname') }}</label>
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', $employer->surname) }}" required autocomplete="surname" autofocus>
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $employer->address, $employer->address) }}" required autocomplete="address" autofocus>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth">{{ __('Date of birth') }}</label>
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $employer->date_of_birth) }}" required autocomplete="date_of_birth" autofocus>
                                @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">{{ __('Phone number') }}</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $employer->phone) }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="external_phone">{{ __('External phone number') }}</label>
                                <input id="external_phone" type="tel" class="form-control @error('external_phone') is-invalid @enderror" name="external_phone" value="{{ old('external_phone', $employer->external_phone) }}" required autocomplete="external_phone" autofocus>
                                @error('external_phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="balance">{{ __('Balance') }}</label>
                                <input id="balance" type="number" min="0" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance', $employer->balance) ?? 0 }}" required autocomplete="balance" autofocus>
                                @error('balance')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="salary">{{ __('Salary') }}</label>
                                <input id="salary" type="number" min="0" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ old('salary', $employer->salary) ?? 0 }}" required autocomplete="salary" autofocus>
                                @error('salary')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="coupon">{{ __('Coupon') }}</label>
                                <input id="coupon" type="text" class="form-control @error('coupon') is-invalid @enderror" name="coupon" value="{{ old('coupon', $employer->coupon) }}" required autocomplete="coupon" autofocus>
                                @error('coupon')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ old('note', $employer->note) }}" required>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ $employer->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ $employer->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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
