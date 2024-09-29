@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Customer</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customer Manage</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                        @csrf
                        @method('PUT')
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
                                                <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $customer->company_name) }}" required>
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
                                                <input type="text" class="form-control" id="prefix" name="prefix" value="{{ old('prefix', $customer->prefix) }}" required>
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
                                            <input type="hidden" name="departments[{{ $index }}][id]" value="{{ $department->id }}">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="department_{{ $index }}" class="form-label">Department</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start">
                                                            <em class="icon ni ni-building"></em>
                                                        </div>
                                                        <input type="text" class="form-control" id="department_{{ $index }}" name="departments[{{ $index }}][department]" value="{{ $department->name }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department_designation_{{ $index }}" class="form-label">Contact Person Designation</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input type="text" class="form-control" id="department_designation_{{ $index }}" name="departments[{{ $index }}][department_designation]" value="{{ $department->users->count() != 0 ? $department->users[0]->designation : '' }}" required>
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
                                                        <input type="text" class="form-control" id="department_contact_person_{{ $index }}" name="departments[{{ $index }}][department_contact_person]" value="{{ $department->users->count() != 0 ? $department->users[0]->name : '' }}" required>
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
                                                        <input type="text" class="form-control" id="department_phone_number_{{ $index }}" name="departments[{{ $index }}][department_phone_number]" value="{{ $department->users->count() != 0 ? $department->users[0]->phone_number : '' }}" >
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
                                                        <input required type="email" class="form-control" id="department_email_{{ $index }}" name="departments[{{ $index }}][department_email]" value="{{ $department->users->count() != 0 ? $department->users[0]->email : '' }}" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="department_users_notification_{{ $index }}" class="form-label">Email Address (for Notifications)</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="js-tags" id="department_users_notification_{{ $index }}" name="departments[{{ $index }}][department_users_notification]" value="{{ $department->notifications->pluck('email')->implode(', ') }}" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end">
                                                <button type="button" class="btn btn-danger remove-department">Remove</button>
                                            </div>
                                        </div>
                                        <hr class="mt-3">
                                    </div>
                                    @endforeach
                                </div>

                                <div class="row mt-3 g-3 gx-gs">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" id="add-department-btn" class="btn btn-outline-primary">Add Another Department</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="card card-bordered mt-3">
                            <div class="card-body">
                                <div class="row mt-3 g-3 gx-gs">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update Customer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('keyup', function(e) {
            if(e.target.type === 'password' || e.target.type === 'email') return;
            if (e.target && e.target.classList.contains('form-control')) {
                e.target.value = e.target.value.toUpperCase();
            }
        });

        document.body.addEventListener('change', function(e) {
            if(e.target.type === 'password' || e.target.type === 'email') return;
            if (e.target && e.target.classList.contains('form-control')) {
                e.target.value = e.target.value.toUpperCase();
            }
        });
    });


    let departmentIndex = {{ $customer->departments->count() }}; // Start index after the existing departments

    const departmentContainer = document.getElementById('department-container');
    const addDepartmentBtn = document.getElementById('add-department-btn');

    // Function to add a new department form
    addDepartmentBtn.addEventListener('click', function() {
        const newDepartmentHtml = `
            <div class="department-row">
                <div class="row g-3 gx-gs">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="department_${departmentIndex}" class="form-label">Department</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                <input type="text" class="form-control" id="department_${departmentIndex}" name="departments[${departmentIndex}][department]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_designation_${departmentIndex}" class="form-label">Contact person name</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-user"></em></div>
                                <input type="text" class="form-control" id="department_designation_${departmentIndex}" name="departments[${departmentIndex}][department_designation]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_contact_person_${departmentIndex}" class="form-label">Contact person name</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-user"></em></div>
                                <input type="text" class="form-control" id="department_contact_person_${departmentIndex}" name="departments[${departmentIndex}][department_contact_person]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_phone_number_${departmentIndex}" class="form-label">Phone number</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                <input type="text" class="form-control" id="department_phone_number_${departmentIndex}" name="departments[${departmentIndex}][department_phone_number]" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_email_${departmentIndex}" class="form-label">Primary Email address</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-at"></em></div>
                                <input required type="email" class="form-control" id="department_email_${departmentIndex}" name="departments[${departmentIndex}][department_email]" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="department_users_notification_${departmentIndex}" class="form-label">Email Address (for Notifications)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="js-tags" id="department_users_notification_${departmentIndex}" name="departments[${departmentIndex}][department_users_notification]" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger remove-department">Remove</button>
                    </div>
                </div>
                <hr class="mt-3">
            </div>
        `;
        departmentContainer.insertAdjacentHTML('beforeend', newDepartmentHtml);
        departmentIndex++;
        
        NioApp.Select('.js-select'); // Reinitialize select input for the new department form
        NioApp.Tags('.js-tags'); // Reinitialize tags input for the new department form
    });

    // Remove a department form
    departmentContainer.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-department')) {
            e.target.closest('.department-row').remove();
        }
    });
</script>
@endsection
