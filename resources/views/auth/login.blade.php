@extends('layouts.auth')

@section('content')
<div class="login-form">
    <!--begin::Form-->
    <form class="form" method="POST"  action="{{ route('login') }}">
        @csrf
        <!--begin::Title-->
        <div class="pb-5 pb-lg-15">
            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
            <!-- <div class="text-muted font-weight-bold font-size-h4">New Here?
            <a href="custom/pages/login/login-4/signup.html" class="text-primary font-weight-bolder">Create Account</a></div> -->
        </div>
        <!--begin::Title-->
        <!--begin::Form group-->
        <div class="form-group">
            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
            <input id="email" type="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
            {{-- <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" /> --}}
        </div>
        <!--end::Form group-->
        <!--begin::Form group-->
        <div class="form-group">
            <div class="d-flex justify-content-between mt-n5">
                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                {{-- <a href="custom/pages/login/login-4/forgot.html" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a> --}}
            </div>
            <input id="password" type="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
            {{-- <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" /> --}}
        </div>
        <!--end::Form group-->
        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>

        </div>
        <!--end::Action-->
    </form>
    <!--end::Form-->
</div>
@endsection
