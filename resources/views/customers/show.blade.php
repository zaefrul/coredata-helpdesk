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
                                    <li class="breadcrumb-item active" aria-current="page">{{ $customer->company_name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex g-3">
                                <li style="margin-right: 1rem">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Edit customer.">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li style="margin-right: 1rem">
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Delete.">
                                            <em class="icon ni ni-trash"></em>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('customers.index') }}" class="btn btn-md btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Back.">
                                        <em class="icon ni ni-arrow-left"></em>
                                    </a>
                                </li>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row g-3 gx-gs">
                                <!-- Company Name -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-building fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Company Name</h6>
                                            <p class="font-weight-bold fs-5">{{ $customer->company_name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Person Name -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-user fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Contact Person Name</h6>
                                            <p class="font-weight-bold fs-5">{{ $customer->contact_person }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-call fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Phone Number</h6>
                                            <p class="font-weight-bold fs-5">{{ $customer->phone_number }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Prefix -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-building fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Company Short Name</h6>
                                            <p class="font-weight-bold fs-5">
                                                <span class="badge text-bg-primary fs-6">{{ $customer->prefix }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-at fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Primary Email Address</h6>
                                            <p class="font-weight-bold fs-5">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 gx-gs mt-1">
                                <!-- Users Notification -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-users fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Users Notification</h6>
                                            <ul class="mt-3">
                                                @foreach ($customer->notifications as $user)
                                                    <li class="list-group-item mb-2">
                                                        <span class="badge text-bg-info fs-4">{{ $user->email }}</span>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
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

@section('js')
<script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
            tooltips.forEach(function(tooltip) {
                tooltip.addEventListener("mouseover", function() {
                    tooltip.setAttribute("title", tooltip.getAttribute("data-original-title"));
                });
                tooltip.addEventListener("mouseout", function() {
                    tooltip.removeAttribute("title");
                });
            });
        });
        
    </script>
@endsection