@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Contract</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contract Manager</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Contract</li>
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('contracts.update', $contract->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Customer Selection --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id" class="form-label" data-bs-toggle="tooltip" title="Select the customer associated with this contract.">Customer</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('customer_id') is-invalid @enderror" data-search="true" data-placeholder="Select a customer..." id="customer_id" name="customer_id">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id', $contract->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('customer_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- select department --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id" class="form-label" data-bs-toggle="tooltip" title="Select the department associated with this contract.">Department</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('department_id') is-invalid @enderror" data-search="true" data-placeholder="Select a department..." id="department_id" name="department_id">
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ old('department_id', $contract->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contract Name -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_name" class="form-label required" data-bs-toggle="tooltip" title="Enter the official name of the contract.">Contract Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="contract_name" name="name" value="{{ old('name', $contract->contract_name) }}" required>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contract Number -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_number" class="form-label required" data-bs-toggle="tooltip" title="Enter the unique contract number.">Contract Number / LOA Number</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('contract_number') is-invalid @enderror" id="contract_number" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" required>
                                            </div>
                                            @error('contract_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date" class="form-label required" data-bs-toggle="tooltip" title="Select the start date of the contract.">Start Date</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
                                            </div>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label required" data-bs-toggle="tooltip" title="Select the end date of the contract.">End Date</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required>
                                            </div>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Unlimited Support --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unlimited_support" class="form-label required" data-bs-toggle="tooltip" title="Check if the contract has unlimited support.">Unlimited Support</label>
                                            <div class="form-control-wrap">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="unlimited_support" name="unlimited_support" value="1" {{ old('unlimited_support', $contract->total_incidence) == -1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="unlimited_support">Yes</label>
                                                </div>
                                            </div>
                                            @error('unlimited_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Total Incidence if support is limited --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_incidence" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of incidence allowed for this contract.">Total Incidence</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('total_incidence') is-invalid @enderror" id="total_incidence" name="total_incidence" value="{{ old('total_incidence', $contract->total_incidence == -1 ? '' : $contract->total_incidence) }}" {{ old('unlimited_support', $contract->total_incidence) == -1 ? 'disabled' : '' }} required>
                                            </div>
                                            @error('total_incidence')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Preventive Maintenance --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="preventive_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Check if preventive maintenance is required for this contract.">Preventive Maintenance</label>
                                            <div class="form-control-wrap">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="preventive_maintenance" name="preventive_maintenance" value="1" {{ old('preventive_maintenance', $contract->preventive_maintenance) > 0 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="preventive_maintenance">Yes</label>
                                                </div>
                                            </div>
                                            @error('preventive_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Total Preventive Maintenance --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_preventive_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of preventive maintenance allowed for this contract.">Total Preventive Maintenance</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('total_preventive_maintenance') is-invalid @enderror" id="total_preventive_maintenance" name="total_preventive_maintenance" value="{{ old('total_preventive_maintenance', $contract->preventive_maintenance) }}" {{ old('preventive_maintenance', $contract->preventive_maintenance) > 0 ? '' : 'disabled' }} required>
                                            </div>
                                            @error('total_preventive_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Corrective Maintenance --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="corrective_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Check if corrective maintenance is required for this contract.">Corrective Maintenance</label>
                                            <div class="form-control-wrap">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="corrective_maintenance" name="corrective_maintenance" value="1" {{ old('corrective_maintenance', $contract->corrective_maintenance) > 0 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="corrective_maintenance">Yes</label>
                                                </div>
                                            </div>
                                            @error('corrective_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Total Corrective Maintenance --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_corrective_maintenance" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of corrective maintenance allowed for this contract.">Total Corrective Maintenance</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('total_corrective_maintenance') is-invalid @enderror" id="total_corrective_maintenance" name="total_corrective_maintenance" value="{{ old('total_corrective_maintenance', $contract->corrective_maintenance) }}" {{ old('corrective_maintenance', $contract->corrective_maintenance) > 0 ? '' : 'disabled' }} required>
                                            </div>
                                            @error('total_corrective_maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description" class="form-label required" data-bs-toggle="tooltip" title="Provide a brief description of the contract.">Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description', $contract->details) }}</textarea>
                                            </div>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- File Upload -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="formFile" class="form-label" data-bs-toggle="tooltip" title="Select contract file in .pdf format.">LOA / PO - Document</label>
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
                                        <button type="submit" class="btn btn-primary">Update Information</button>
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
            // Convert input values to uppercase
            document.querySelectorAll('.form-control').forEach(function(el) {
                el.addEventListener('keyup', function(e) {
                    this.value = this.value.toUpperCase();
                });
                el.addEventListener('change', function(e) {
                    this.value = this.value.toUpperCase();
                });
            });

            // Unlimited Support toggle
            document.getElementById('unlimited_support').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('total_incidence').disabled = true;
                    document.getElementById('total_incidence').value = '';
                } else {
                    document.getElementById('total_incidence').disabled = false;
                }
            });

            // Preventive Maintenance toggle
            document.getElementById('preventive_maintenance').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('total_preventive_maintenance').disabled = false;
                } else {
                    document.getElementById('total_preventive_maintenance').disabled = true;
                    document.getElementById('total_preventive_maintenance').value = '';
                }
            });

            // Corrective Maintenance toggle
            document.getElementById('corrective_maintenance').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('total_corrective_maintenance').disabled = false;
                } else {
                    document.getElementById('total_corrective_maintenance').disabled = true;
                    document.getElementById('total_corrective_maintenance').value = '';
                }
            });
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
    </script>
@endsection
