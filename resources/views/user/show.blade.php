@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">User Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex g-3">
                                <li style="margin-right: 1rem">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Edit user.">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li style="margin-right: 1rem">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Delete.">
                                            <em class="icon ni ni-trash"></em>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('users.index') }}" class="btn btn-md btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Back.">
                                        <em class="icon ni ni-arrow-left"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row g-3 gx-gs">
                                <!-- Customer -->
                                @if($user->customer)
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-building fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Customer</h6>
                                            <p class="font-weight-bold fs-5">{{ $user->customer->company_name }} [{{ $user->customer->prefix }}]</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-user fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Name</h6>
                                            <p class="font-weight-bold fs-5">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-mail fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Email</h6>
                                            <p class="font-weight-bold fs-5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-call fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Phone Number</h6>
                                            <p class="font-weight-bold fs-5">{{ $user->phone_number }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-6">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body">
                                            <em class="icon ni ni-users fs-2 text-primary me-3"></em>
                                            <h6 class="title text-uppercase text-muted">Role</h6>
                                            <p class="font-weight-bold fs-5">
                                                @if($user->role == 'admin')
                                                    <span class="badge text-bg-primary">Admin</span>
                                                @elseif($user->role == 'agent')
                                                    <span class="badge text-bg-info">Agent</span>
                                                @else
                                                    <span class="badge text-bg-secondary">User</span>
                                                @endif
                                            </p>
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
