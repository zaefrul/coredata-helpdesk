@extends('layouts.auth')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-auth" style="opacity: 0.95;">
                        <div class="card-body" style="margin: 5rem;">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h1>404</h1>
                                    <h2>Page not found</h2>
                                    <p>We are sorry but the page you are looking for does not exist.</p>
                                    <a href="{{ route('dashboard') }}" class="btn btn-warning btn-sm">Back to Home</a>
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