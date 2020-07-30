@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 my-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-3">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4">
                                        Sign Up!
                                    </h4>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group">
                                            <input
                                                id="name"
                                                type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name"
                                                value="{{ old('name') }}"
                                                required
                                                autocomplete="name"
                                                autofocus
                                                placeholder="Full name">

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input
                                                id="email"
                                                type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                                autocomplete="email"
                                                placeholder="Email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input
                                                id="password"
                                                type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password"
                                                required
                                                autocomplete="new-password"
                                                placeholder="Password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input
                                                id="password-confirm"
                                                type="password"
                                                class="form-control"
                                                name="password_confirmation"
                                                required
                                                autocomplete="new-password"
                                                placeholder="Confirm password">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('CREATE ACCOUNT') }}
                                            </button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted pl-0" href="{{ route('login') }}">
                                                {{ __('Already Have an Account?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
