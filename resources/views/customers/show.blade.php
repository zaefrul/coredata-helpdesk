@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Customer Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customer Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $customer->company }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-edit"></em>
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-edit"></em>
                                        <span>Edit Customer</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <h5 class="text-uppercase text-muted">Customer Information</h5>
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <p><strong>Company Name:</strong> {{ $customer->company_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Contact Person Name:</strong> {{ $customer->contact_person }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Phone Number:</strong> {{ $customer->phone_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Email Address:</strong> {{ $customer->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Company Prefix:</strong> {{ $customer->prefix }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
