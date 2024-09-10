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
                            {{-- <pre>
                                @if($errors->any())
                                    {{ print_r($errors->all()) }}
                                @endif
                                @if(old())
                                    {{ print_r(old()) }}
                                @endif
                            </pre> --}}
                            <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data" novalidate>
                                @csrf

                                {{-- customer selection --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id" class="form-label" data-bs-toggle="tooltip" title="Select the customer associated with this contract.">Customer</label>
                                            <div class="form-control-wrap"  @error('customer_id') style="border: solid 1px red; border-radius: 0.375rem" @enderror>
                                                <select class="js-select" data-search="true" data-placeholder="Select a customer..." id="customer_id" name="customer_id">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->company_name }} [{{$customer->prefix}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('customer_id')
                                                <div class="invalid-feedback" style="display:block !important;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id" class="form-label" data-bs-toggle="tooltip" title="Select the department associated with this contract.">Department</label>
                                            <div class="form-control-wrap" @error('customer_id') style="border: solid 1px red; border-radius: 0.375rem" @enderror>
                                                <select class="js-select @error('department_id') is-invalid @enderror" data-search="true" data-placeholder="Select a department..." id="department_id" name="department_id">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>
                                            @error('department_id')
                                                <div class="invalid-feedback" style="display:block !important;">{{ $message }}</div>
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
                                                <textarea class="form-control @error('name') is-invalid @enderror" id="contract_name" name="name" >{{ old('name') }}</textarea>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contract Number -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract_number" class="form-label required" data-bs-toggle="tooltip" title="Enter the unique contract number.">Letter of award / Purchase order number / Letter of intention</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('contract_number') is-invalid @enderror" id="contract_number" name="contract_number" value="{{ old('contract_number') }}" required>
                                                @error('contract_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- date picker component --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        @php
                                            if(old('start_date') && old('end_date')) {
                                                $oldStartDate = \Carbon\Carbon::createFromFormat('Y-m-d', old('start_date'))->format('d/m/Y');
                                                $oldEndDate = \Carbon\Carbon::createFromFormat('Y-m-d', old('end_date'))->format('d/m/Y');
                                                $duration = \Carbon\Carbon::createFromFormat('Y-m-d', old('start_date'))->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', old('end_date'))) - 1;
                                            } else {
                                                $oldStartDate = '';
                                                $oldEndDate = '';
                                                $duration = '';
                                            }

                                            $errorStartDate = $errors->has('start_date') ? $errors->first('start_date') : '';
                                            $errorEndDate = $errors->has('end_date') ? $errors->first('end_date') : '';
                                        @endphp
                                        <x-date-range-picker label="Contract Period" startDate="{{ $oldStartDate }}" endDate="{{ $oldEndDate }}" duration="{{$duration}}" errorStartDate="{{$errorStartDate}}" errorEndDate="{{$errorEndDate}}" />
                                    </div>
                                </div>

                                {{-- total incidence (add checkbox or switch first col-md-6 to indicate if support is unlimitted or not) --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-group">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="unlimited_support" name="unlimited_support" value="1" {{ old('unlimited_support') == 1 ? 'checked' : '' }}>
                                                <label style="line-height: 1.75rem;padding-left: 0.75rem;" class="form-label" for="unlimited_support">Unlimited Support</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- if support is limited, enable this field to specify number of incidence per contract --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_incidence" class="form-label required" data-bs-toggle="tooltip" title="Enter the total number of incidence allowed for this contract.">Total Incidence</label>
                                            <div class="form-control-wrap">
                                                <input {{ old('unlimited_support') == 1 ? 'disabled' : '' }} type="number" class="form-control @error('total_incidence') is-invalid @enderror" id="total_incidence" name="total_incidence" value="{{ old('total_incidence') }}" required>
                                                @error('total_incidence')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- total preventive maintenance (add checkbox or switch in the first col-md-6 to indicate if preventive maintenance is require or not. if not set value to -1) --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-group">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="preventive_maintenance" name="preventive_maintenance" value="1" {{ old('preventive_maintenance') == 1 ? 'checked' : '' }}>
                                                <label style="line-height: 1.75rem;padding-left: 0.75rem;" class="form-label" for="preventive_maintenance" data-bs-toggle="tooltip" title="Check if preventive maintenance is required for this contract.">Preventive Maintenance</label>
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
                                                <input {{ old('preventive_maintenance') == 1 ? '' : 'disabled' }} type="number" class="form-control @error('total_preventive_maintenance') is-invalid @enderror" id="total_preventive_maintenance" name="total_preventive_maintenance" value="{{ old('total_preventive_maintenance') }}" required>
                                                @error('total_preventive_maintenance')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label required" data-bs-toggle="tooltip" title="Provide a brief description of the contract.">Other Requirement</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                                                @error('file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
            document.querySelectorAll('.form-control').forEach(function(el) {
                el.addEventListener('keyup', function(e) {
                    if(el.type === 'email' || el.type === 'password') return;
                    this.value = this.value.toUpperCase();
                });
                el.addEventListener('change', function(e) {
                    if(el.type === 'email' || el.type === 'password') return;
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
        const oldDepartmentId = "{{ old('department_id') }}";
        const oldCustomerId = "{{ old('customer_id') }}";

        document.getElementById('customer_id').addEventListener('change', function(e) {
            var customer_id = this.value;
            var department_id = document.getElementById('department_id');

            // clear department_id select
            departmentChoice.clearStore();

            if (customer_id) {
                getDepartmentByCustomerId(customer_id);
            } else {
                departmentChoice.disable();
            }
        });

        function constructDepartmentOption(departments)
        {
            var options = [];
            departments.forEach(function(department) {
                const selected = oldDepartmentId !== 0 && department.id == oldDepartmentId ? true : false;
                options.push({value: department.id, label: department.name, selected, disabled: false});
            });
            departmentChoice.setChoices(options, 'value', 'label', true);
            departmentChoice.enable();
        }

        function getDepartmentByCustomerId(customer_id)
        {
            var url = "/customers/" + customer_id + "/departments";
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
            })
            .then(response => {console.log(response); return response.json();})
            .then(data => {
                constructDepartmentOption(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        if (oldDepartmentId && oldCustomerId) {
            getDepartmentByCustomerId(oldCustomerId);
        }
    </script>
@endsection