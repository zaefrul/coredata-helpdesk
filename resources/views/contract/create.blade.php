@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Project</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Project Manager</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add New Project</li>
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('contracts.store') }}">
                                @csrf

                                {{-- customer selection --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id" class="form-label" data-bs-toggle="tooltip" title="Select the customer associated with this contract.">Customer</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('customer_id') is-invalid @enderror" data-search="true" data-placeholder="Select a customer..." id="customer_id" name="customer_id">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('customer_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id" class="form-label" data-bs-toggle="tooltip" title="Select the department associated with this contract.">Department</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('department_id') is-invalid @enderror" data-search="true" data-placeholder="Select a department..." id="department_id" name="department_id">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- department selection --}}
                                <div class="row g-3 gx-gs mb-3">
                                    
                                </div>

                                <!-- Contract Name -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract_name" class="form-label required" data-bs-toggle="tooltip" title="Enter the official name of the contract.">Project Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                {{-- <input type="text" class="form-control @error('name') is-invalid @enderror" id="contract_name" name="name" value="{{ old('name') }}" required> --}}
                                                <textarea class="form-control @error('name') is-invalid @enderror" id="contract_name" name="name" required>{{ old('name') }}</textarea>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contract Number -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract_number" class="form-label required" data-bs-toggle="tooltip" title="Enter the unique contract number.">Letter of award / Purchase order number / Letter of intention</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('contract_number') is-invalid @enderror" id="contract_number" name="contract_number" value="{{ old('contract_number') }}" required>
                                            </div>
                                            @error('contract_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Contract Period</label>
                                            <div class="input-group custom-datepicker" data-range="init" >
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" name="start_date" id="contract_start_date">
                                                <span class="input-group-text">to</span>
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" name="end_date" id="contract_end_date">
                                                <span class="input-group-text" id="how-many-month-days">0 day</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- total incidence (add checkbox or switch first col-md-6 to indicate if support is unlimitted or not) --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-group">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="unlimited_support" name="unlimited_support" value="1" {{ old('unlimited_support') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="unlimited_support">Unlimited Support</label>
                                            </div>
                                            @error('unlimited_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- if support is limited, enable this field to specify number of incidence per contract --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_incidence" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of incidence allowed for this contract.">Total Incidence</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('total_incidence') is-invalid @enderror" id="total_incidence" name="total_incidence" value="{{ old('total_incidence') }}" required>
                                            </div>
                                            @error('total_incidence')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- total preventive maintenance (add checkbox or switch in the first col-md-6 to indicate if preventive maintenance is require or not. if not set value to -1) --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-group">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="preventive_maintenance" name="preventive_maintenance" value="1" {{ old('preventive_maintenance') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="preventive_maintenance" data-bs-toggle="tooltip" title="Check if preventive maintenance is required for this contract.">Preventive Maintenance</label>
                                            </div>
                                            @error('preventive_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- if preventive maintenance is not required, set value to -1 --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_preventive_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of preventive maintenance allowed for this contract.">Total Preventive Maintenance</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="number" class="form-control @error('total_preventive_maintenance') is-invalid @enderror" id="total_preventive_maintenance" name="total_preventive_maintenance" value="{{ old('total_preventive_maintenance') }}" required>
                                            </div>
                                            @error('total_preventive_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                    
                                {{-- total corrective maintenance (add checkbox or switch in the first col-md-6 to indicate if corrective maintenance is require or not. if not set value to -1) --}}
                                {{-- <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="corrective_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Check if corrective maintenance is required for this contract.">Corrective Maintenance</label>
                                            <div class="form-control-wrap">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="corrective_maintenance" name="corrective_maintenance" value="1" {{ old('corrective_maintenance') == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="corrective_maintenance">Yes</label>
                                                </div>
                                            </div>
                                            @error('corrective_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_corrective_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of corrective maintenance allowed for this contract.">Total Corrective Maintenance</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="number" class="form-control @error('total_corrective_maintenance') is-invalid @enderror" id="total_corrective_maintenance" name="total_corrective_maintenance" value="{{ old('total_corrective_maintenance') }}" required>
                                            </div>
                                            @error('total_corrective_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}


                                <!-- Description -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label required" data-bs-toggle="tooltip" title="Provide a brief description of the contract.">Other Requirement</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
                                            </div>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- file upload and display doc symbol -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="formFile" class="form-label" data-bs-toggle="tooltip" title="Select contract file in .pdf format.">LOA / PO / LOI</label>
                                            <div class="form-control-wrap">
                                                <input class="form-control" type="file" id="formFile" name="file" accept=".pdf">
                                            </div>
                                            @error('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit and Cancel -->
                                <div class="row g-3 gx-gs mn-3">
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mn-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save Information</button>
                                        <a href="{{ route('contracts.index') }}" class="btn btn-warning">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Select2
            document.querySelectorAll('.form-control').forEach(function(el) {
                // convert to to uppercase
                el.addEventListener('keyup', function(e) {
                    this.value = this.value.toUpperCase();
                });
                el.addEventListener('change', function(e) {
                    this.value = this.value.toUpperCase();
                });
            });

            // Unlimited Support
            document.getElementById('unlimited_support').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('total_incidence').disabled = true;
                    document.getElementById('total_incidence').value = '';
                } else {
                    document.getElementById('total_incidence').disabled = false;
                }
            });

            // Preventive Maintenance
            document.getElementById('preventive_maintenance').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('total_preventive_maintenance').disabled = false;
                } else {
                    document.getElementById('total_preventive_maintenance').disabled = true;
                    document.getElementById('total_preventive_maintenance').value = '';
                }
            });

            // Corrective Maintenance
            // document.getElementById('corrective_maintenance').addEventListener('change', function(e) {
            //     if (this.checked) {
            //         document.getElementById('total_corrective_maintenance').disabled = false;
            //     } else {
            //         document.getElementById('total_corrective_maintenance').disabled = true;
            //         document.getElementById('total_corrective_maintenance').value = '';
            //     }
            // });
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // get choice instance on the department_id select
        var departmentChoice = new Choices(document.getElementById('department_id'), {
            searchEnabled: true,
            searchChoices: true,
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Select Department',
            noResultsText: 'No department found, please notify the administrator.',
            itemSelectText: 'Press to select',
        });

        departmentChoice.disable();

        // if customer_id select change, query department from the server
        document.getElementById('customer_id').addEventListener('change', function(e) {
            var customer_id = this.value;
            var department_id = document.getElementById('department_id');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // clear department_id select
            departmentChoice.clearStore();

            if (customer_id) {
                var url = "/customers/" + customer_id + "/departments";
                console.log(url);
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                })
                .then(response => {console.log(response); return response.json();})
                .then(data => {
                    console.log(data);
                    if(data.length > 0) {
                        const options = [];
                        data.forEach(function(department) {
                            options.push({value: department.id, label: department.name, selected: false, disabled: false});
                        });
                        departmentChoice.setChoices(options, 'value', 'label', true);
                        departmentChoice.enable();
                    } else {
                        departmentChoice.disable();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                departmentChoice.disable();
            }
        });

        // Date Picker
        const dpElement = document.querySelector('.custom-datepicker');
        const datepicker = new DateRangePicker(dpElement, {
            autohide: true,
            buttonClass: 'btn btn-md',
            orientation: 'bottom',
            todayButton: false,
            format: 'dd/mm/yyyy',
            
        });

        // Bind the change event directly on both input fields controlled by the date picker
        const startDateInput = document.getElementById('contract_start_date');
        const endDateInput = document.getElementById('contract_end_date');

        startDateInput.addEventListener('changeDate', updateDateDifference);
        endDateInput.addEventListener('changeDate', updateDateDifference);

        function updateDateDifference() {
            const startDateValue = startDateInput.value;
            const endDateValue = endDateInput.value;

            if (startDateValue && endDateValue) {
                // Parse the dates in dd/mm/yyyy format
                const [startDay, startMonth, startYear] = startDateValue.split('/');
                const [endDay, endMonth, endYear] = endDateValue.split('/');

                const startDate = new Date(`${startYear}-${startMonth}-${startDay}`);
                const endDate = new Date(`${endYear}-${endMonth}-${endDay}`);

                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Difference in days

                // Update the difference display
                document.getElementById('how-many-month-days').innerText = `${diffDays} day(s)`;

                // Optionally, calculate the difference in months
                const months = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());
                console.log(`Difference in months: ${months}`);
            }
        }
    </script>
@endsection