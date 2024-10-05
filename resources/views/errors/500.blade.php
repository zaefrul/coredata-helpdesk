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
                                    <h1>500</h1>
                                    <h2>Somethings are not right!</h2>
                                    <p>This shouldn't be happening! our team will try our best to address this hiccup!</p>
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