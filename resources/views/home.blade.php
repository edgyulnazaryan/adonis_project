@extends('layouts.app')

@section('content')
<div class="container">
    @if(\Session::has('error'))
        <div class="alert alert-danger">
            {{\Session::get('error')}}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!empty($activeUsers))
                    <ul class="list-group">
                        @foreach($activeUsers as $activeUser)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-monospace text-decoration-none text-reset">{{ $activeUser->name . ' ' . $activeUser->surname }}</span>
                                <span class="badge bg-danger rounded-pill userStatus user-icon-{{ $activeUser->id }}"></span>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">{{ __('Employers') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!empty($activeEmployers))
                        <ul class="list-group">
                            @foreach($activeEmployers as $activeEmployer)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('employer.show', $activeEmployer) }}" class="text-monospace text-decoration-none text-reset">{{ $activeEmployer->name . ' ' . $activeEmployer->surname }}</a>
                                    <span class="badge bg-danger rounded-pill employerStatus employer-icon-{{ $activeEmployer->id }}"></span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        const socketUser = io.connect('http://192.168.224.162:3030');
        const socketEmployer = io.connect('http://192.168.224.162:3031');
        let userId = $('input[name="userId"]').val();
        socketUser.emit('online', {
            'userId': userId
        })

        let employerId = $('input[name="employerUuid"]').val();
        socketEmployer.emit('onlineEmployer', {
            'employerId' : employerId
        })

        socketEmployer.on('updateEmployerStatus', function (employers) {
            let employerStatusIcon = $(".employerStatus")
            employerStatusIcon.addClass('bg-danger')
            employerStatusIcon.removeClass('bg-success')
            employerStatusIcon.html('Offline')

            $.each(employers, function (key, value) {
                if(value != null && value != 0) {
                    console.log(key, value)
                    let employerIcon = $(".employer-icon-" + key)
                    employerIcon.addClass('bg-success')
                    employerIcon.removeClass('bg-danger')
                    employerIcon.html('Online')
                }
            })
        })

        socketUser.on('updateUserStatus', function (data) {
            let userStatusIcon = $(".userStatus")
            userStatusIcon.addClass('bg-danger')
            userStatusIcon.removeClass('bg-success')
            userStatusIcon.html('Offline')
            console.log("DATA", data)
            $.each(data, function (key, value) {
                if(value != null && value != 0) {
                    let userIcon = $(".user-icon-" + key)
                    userIcon.addClass('bg-success')
                    userIcon.removeClass('bg-danger')
                    userIcon.html('Online')
                }
            })
        })
    })
</script>
@endsection

<style>
    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .list-group-item {
        border-color: rgba(0, 0, 0, 0.125);
    }

    .badge {
        font-size: 0.8rem;
        font-weight: normal;
    }

</style>

