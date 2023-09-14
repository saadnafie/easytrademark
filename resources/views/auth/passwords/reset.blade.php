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
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
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

                                    <div class="form-group ">
                                        <label>
                                            <input id="password" type="password"
                                                   class="my_form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="new-password">
                                            <small class="my_place">Password</small>
                                        </label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                        @enderror

                                    </div>

                                    <div class="form-group ">
                                        <label>
                                            <input id="password-confirm" type="password" class="my_form-control"
                                                   name="password_confirmation" required autocomplete="new-password">
                                            <small class="my_place">confirm password</small>
                                        </label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                                        @enderror

                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary mx-auto">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
