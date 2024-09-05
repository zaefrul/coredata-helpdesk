@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Customer</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customer Manage</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add New Customer</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <div class="card card-bordered">
                            <div class="card-body">
                                <div class="row g-3 gx-gs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company" class="form-label">Company name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control " id="company" name="company" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="prefix" class="form-label">Company prefix (short name)</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control" id="prefix" required name="prefix" placeholder="SUHAKAM, MOT, MBSJ, PTD..">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 g-3 gx-gs">
                                    {{-- submit btn --}}
                                    <div class="col-12">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-primary">Add Customer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- department --}}
                        <div class="card card-bordered mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Department Form</h5>
                                <div id="department-container">
                                    <div class="department-row">
                                        <div class="row g-3 gx-gs">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department" class="form-label">Department</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                        <input type="text" class="form-control" id="department" name="departments[0][department]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department_contact_person" class="form-label">Contact person name</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start"><em class="icon ni ni-user"></em></div>
                                                        <input type="text" class="form-control" id="department_contact_person" name="departments[0][department_contact_person]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department_phone_number" class="form-label">Phone number</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                                        <input type="text" class="form-control" id="department_phone_number" name="departments[0][department_phone_number]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department_email" class="form-label">Primary Email address</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start"><em class="icon ni ni-at"></em></div>
                                                        <input type="email" class="form-control" id="department_email" name="departments[0][department_email]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="department_users_notification" class="form-label">Email Address (for notifications)</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="js-tags" id="department_users_notification" name="departments[0][department_users_notification]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end">
                                                <button type="button" class="btn btn-danger remove-department">Remove</button>
                                            </div>
                                        </div>
                                        <hr class="mt-3">
                                    </div>
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

                        {{-- submit button --}}
                        <div class="card card-bordered mt-3">
                            <div class="card-body">
                                <div class="row mt-3 g-3 gx-gs">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Add Customer</button>
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
    //all input fields with class 'form-control' will be affected. each key/change will convert to uppercase
    //this is to ensure that all data entered are in uppercase pure javascript
    // all input type exept for password and email
    document.querySelectorAll('.form-control').forEach(function (input) {
        console.log(input)
        if(input.type === 'password' || input.type === 'email') return;
        input.addEventListener('keyup', function (e) {
            this.value = this.value.toUpperCase();
        });
        //change
        input.addEventListener('change', function (e) {
            this.value = this.value.toUpperCase();
        });
    });

    // department handler
    let departmentIndex = 1; // Start at index 1 since 0 is already rendered
    const departmentContainer = document.getElementById('department-container');
    const addDepartmentBtn = document.getElementById('add-department-btn');

    // Function to add a new department form
    addDepartmentBtn.addEventListener('click', function() {
        const newDepartmentHtml = `
            <div class="department-row">
                <div class="row g-3 gx-gs">
                    <div class="col-md-6">
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
                                <input type="text" class="form-control" id="department_phone_number_${departmentIndex}" name="departments[${departmentIndex}][department_phone_number]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_email_${departmentIndex}" class="form-label">Primary Email address</label>
                            <div class="form-control-wrap">
                                <div class="form-control-icon start"><em class="icon ni ni-at"></em></div>
                                <input type="email" class="form-control" id="department_email_${departmentIndex}" name="departments[${departmentIndex}][department_email]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="department_users_notification_${departmentIndex}" class="form-label">Email Address (for notifications)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="js-tags" id="department_users_notification_${departmentIndex}" name="departments[${departmentIndex}][department_users_notification]" required>
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