@extends('client.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login center-block">
                    <div class=" myCtn">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="text-center mt-3">Reset Password</h2>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group ">
                                        <label>
                                            <input id="email" type="email"
                                                   class="my_form-control @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}" required autofocus>
                                            <small class="my_place">Email</small>
                                        </label>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                        @enderror

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary mx-auto">
                                            Send Password
                                        </button>
                                    </div>
                                    <div class="form-group mt-4 text-center">
                                        <a href="{{ route('login') }}"> <span class="forgot"> Login </span></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
