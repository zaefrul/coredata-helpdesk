@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Customer Detail</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customer Manage</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{$customer->company_name}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row g-3 gx-gs">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company" class="form-label">Company Name</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-icon start">
                                                <em class="icon ni ni-building"></em>
                                            </div>
                                            <input disabled type="text" class="form-control" id="company" name="company" value="{{ old('company', $customer->company_name) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prefix" class="form-label">Company Prefix</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-icon start">
                                                <em class="icon ni ni-building"></em>
                                            </div>
                                            <input disabled type="text" class="form-control" id="prefix" name="prefix" value="{{ old('prefix', $customer->prefix) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Department Section --}}
                    <div class="card card-bordered mt-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Department Form</h5>
                            <div id="department-container">
                                @foreach($customer->departments as $index => $department)
                                <div class="department-row">
                                    <div class="row g-3 gx-gs">
                                        <input disabled type="hidden" name="departments[{{ $index }}][id]" value="{{ $department->id }}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_{{ $index }}" class="form-label">Department</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start">
                                                        <em class="icon ni ni-building"></em>
                                                    </div>
                                                    <input disabled type="text" class="form-control" id="department_{{ $index }}" name="departments[{{ $index }}][department]" value="{{ $department->name }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_contact_person_{{ $index }}" class="form-label">Contact Person Name</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start">
                                                        <em class="icon ni ni-user"></em>
                                                    </div>
                                                    <input disabled type="text" class="form-control" id="department_contact_person_{{ $index }}" name="departments[{{ $index }}][department_contact_person]" value="{{ $department->pc_name }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_phone_number_{{ $index }}" class="form-label">Phone Number</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start">
                                                        <em class="icon ni ni-call"></em>
                                                    </div>
                                                    <input disabled type="text" class="form-control" id="department_phone_number_{{ $index }}" name="departments[{{ $index }}][department_phone_number]" value="{{ $department->pc_phone }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_email_{{ $index }}" class="form-label">Primary Email Address</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start">
                                                        <em class="icon ni ni-at"></em>
                                                    </div>
                                                    <input disabled type="email" class="form-control" id="department_email_{{ $index }}" name="departments[{{ $index }}][department_email]" value="{{ $department->pc_email }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="department_users_notification_{{ $index }}" class="form-label">Email Address (for Notifications)</label>
                                                <div class="form-control-wrap">
                                                    <input disabled type="text" class="js-tags" id="department_users_notification_{{ $index }}" name="departments[{{ $index }}][department_users_notification]" value="{{ $department->notifications->pluck('email')->implode(', ') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mt-5 mb-5">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Edit Button --}}
                    <div class="card card-bordered mt-3">
                        <div class="card-body">
                            <div class="row mt-3 g-3 gx-gs">
                                <div class="col-12">
                                    <div class="form-group">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
                                            <em class="icon ni ni-edit"></em>
                                            Edit Customer
                                        </a>
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
