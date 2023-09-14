@extends('client.layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login center-block">
                    <div class=" myCtn">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="text-center mt-3">Register</h2>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group ">
                                        <input id="name" type="text"
                                               class="my_form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{ old('name') }}" required autofocus>
                                        <small class="my_place">Name *</small>
                                        @if ($errors->has('name'))
                                            <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input id="email" type="email"
                                                   class="my_form-control @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}" required autofocus>
                                            <small class="my_place">Email *</small>
                                        </label>
                                        @if ($errors->has('email'))
                                            <p class="alert alert-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input id="phone" type="text"
                                                   class="my_form-control @error('phone') is-invalid @enderror"
                                                   name="phone" value="{{ old('phone') }}" autofocus>
                                            <small class="my_place">Phone Number</small>
                                        </label>
                                        @if ($errors->has('phone'))
                                            <p class="alert alert-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label>
                                            <input id="password" type="password"
                                                   class="my_form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   value="{{ old('password') }}" required autofocus>
                                            <small class="my_place">Password *</small>
                                        </label>
                                        @if ($errors->has('password'))
                                            <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label>
                                            <input id="password-confirm" type="password"
                                                   class="my_form-control @error('password') is-invalid @enderror"
                                                   name="password_confirmation" value="{{ old('new-password') }}"
                                                   required autofocus>
                                            <small class="my_place">Confirm password *</small>
                                        </label>

                                        <br>
                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                        <script>
                                            function onSubmit(token) {
                                                document.getElementById("demo-form").submit();
                                            }

                                            grecaptcha.execute();
                                        </script>
                                        <br>
                                        <div class="form-group text-center">
                                            <div class="container">
                                                @if (env('APP_ENV') == 'production')
                                                    <div class="g-recaptcha"
                                                         data-sitekey="6LcriscZAAAAAKzeYYRaG9ajcCmZuENlPH40_tkq">
                                                    </div>
                                                @else
                                                    <div class="g-recaptcha"
                                                         data-sitekey="6LfP6ccZAAAAAGUPgJBzFJo5NyD4zSrUnyo0FCPb">
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <p class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary mt-3 mx-auto">
                                            Register
                                        </button>
                                    </div>
                                    <div class="form-group mt-4 text-center">
                                        <a href="{{ route('login') }}"> <span class="forgot"> Have an Account ? </span></a>
                                    </div>

                                    <div class="form-group mt-4 text-center">
                                        <span class="forgot"><a
                                                href="{{ route('password.request') }}">Forgot password ?</a></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
