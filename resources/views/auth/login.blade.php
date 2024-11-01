@extends('layouts.auth')

@php
    // URL Parameter, if have style=1, then use the dark theme
    $style = request()->query('style');
    $style = $style == 1 ? 'bg1' : 'bg1';
@endphp

@section('content')
<div class="container p-2 p-sm-4">
    <div class="row @if($style == 'bg2') flex-lg-row-reverse @else flex-lg-row @endif">
        <div class="col-lg-5">
            <div class="card card-gutter-lg rounded-4 card-auth login-form" style="border: none !important; box-shadow: none !important;">
                <div class="card-body">
                    <div class="brand-logo mb-4" style="margin-right: 10px !important;">
                        <a href="/" class="logo-link">
                            <div class="logo-wrap">
                                <img class="logo-img logo-img-lg" src="./images/3.png" srcset="./images/3.png" alt="">
                                {{-- <img class="logo-img logo-light" width="300px" height="auto" src="./images/3.png" srcset="./images/3.png" alt=""> --}}
                                {{-- <img class="logo-img logo-dark" width="300px" height="auto" src="./images/3.png" srcset="./images/3.png" alt=""> --}}
                                <img class="logo-img logo-icon" width="300px" height="auto" src="./images/3.png" srcset="./images/3.png" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title mb-1">Login to Account</h3>
                            <p class="small">Please sign-in to your account so that we can help you.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email address</label>
                                    <div class="form-control-wrap">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter username">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- .form-group -->
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- .form-group -->
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" name="remember" type="checkbox" value="" id="remember">
                                        <label class="form-check-label" for="remember"> Remember Me </label>
                                    </div>
                                    {{-- <a href="./html/auths/auth-reset-fancy.html" class="small">Forgot Password?</a> --}}
                                    <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>

                                </div>
                                
                            </div>
                            @if (Route::has('password.request'))
                                <div class="col-12">
                                    
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Login to account</button>
                                </div>
                            </div>
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
        {{-- <div class="d-none d-md-block col-lg-7 align-self-center">
            <div class="card-body is-theme ps-lg-4 pt-5 pt-lg-0">
                <div class="row">
                    <div class="col-sm-8">
                        <div style="text-shadow: 1px 1px 10px #000" class="h1 title mb-3">Welcome back to <br> our support hub.</div>
                        <p style="text-shadow: 1px 1px 10px #000">Your go-to place for managing and resolving incidents seamlessly. We prioritize your security and efficiency. Whether you're reporting an issue, managing assets, or keeping projects on track, our platform empowers you to stay in control with confidence.</p>
                    </div>
                </div><!-- .row -->
            </div><!-- .card-body -->
        </div><!-- .col --> --}}
    </div><!-- .row -->
</div><!-- .container -->
@endsection