@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Asset</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Asset Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add New Asset</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('assets.store') }}" novalidate>
                                @csrf
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract_id" class="form-label">Contract</label>
                                            <div class="form-control-wrap" @error('contract_id') style="border: solid 1px red; border-radius: 0.375rem" @enderror>
                                                <select class="js-select" data-search="true" data-sort="false" id="contract_id" name="contract_id" required>
                                                    <option>Select Contract</option>
                                                    @foreach($contracts as $contract)
                                                        <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}>{{ $contract->contract_name }} [{{ $contract->contract_number }}]</option>
                                                    @endforeach
                                                </select>
                                                @error('contract_id')
                                                    <div class="invalid-feedback" style="display:block !important;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Model, Brand, Serial Number, and Category -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label required">Model Name / Software Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand" class="form-label">Brand name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}" required>
                                                @error('brand')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serial_number" class="form-label"> Serial Number / Software Contract Number</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                                                @error('serial_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Category</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <select class="js-select" data-search="true" name="category" id="category" required>
                                                    <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                                    <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software</option>
                                                    <option value="service" {{ old('category') == 'software' ? 'selected' : '' }}>service</option>
                                                </select>
                                            </div>
                                            @error('category')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Asset Description -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="details" class="form-label">Asset Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details">{{ old('details') }}</textarea>
                                                @error('details')
                                                    <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty_level" class="form-label">Warranty Level</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" id="warranty_level" name="warranty_level" required>
                                                    <option value="">Select Warranty Level</option>
                                                    <option value="third-party" {{ old('warranty_level') == '1' ? 'selected' : '' }}>3rd Party</option>
                                                    <option value="back-to-back" {{ old('warranty_level') == '2' ? 'selected' : '' }}>Back to Back</option>
                                                </select>
                                            </div>
                                            @error('warranty_level')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchase Date and Warranty End -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Warranty Period</label>
                                            <div class="input-group custom-datepicker" data-range="init" >
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control @error('purchased_date') is-invalid @enderror" id="warranty_start" name="purchased_date" value="{{ old('purchased_date') }}" {{old('same_as_contract') == "1" ? 'disabled' : ''}}>
                                                <span class="input-group-text">to</span>
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control @error('warranty_end') is-invalid @enderror" id="warranty_end" name="warranty_end" value="{{ old('warranty_end') }}" {{old('same_as_contract') == "1" ? 'disabled' : ''}}>
                                                <span class="input-group-text" id="how-many-month-days">0 day</span>
                                            </div>
                                            @error('purchased_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('warranty_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- checkbox for user who want to take date the same like contract period --}}
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="same_as_contract" name="same_as_contract" value="1" {{old('same_as_contract') == "1" ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="same_as_contract">Same as Contract Period</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- location --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location" class="form-label">Location</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-map-pin"></em></div>
                                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                                                @error('location')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Asset Components Section -->
                                <div class="row g-3 gx-gs mb-3 mt-3">
                                    <div class="col-12">
                                        <h5>Asset Components</h5>
                                        <div id="component-list">
                                            <!-- Dynamically added components will appear here -->
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" onclick="addComponent()">Add Component</button>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="row mt-3 g-3 gx-gs">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary col-md-2">
                                                <em class="icon ni ni-save"></em> <span class="ml-1">Add Asset</span>
                                            </button>
                                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('keyup', function(e) {
            if (e.target && e.target.classList.contains('form-control')) {
                e.target.value = e.target.value.toUpperCase();
            }
        });

        document.body.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('form-control')) {
                e.target.value = e.target.value.toUpperCase();
            }
        });
    });


    let componentIndex = 0;

        function addComponent(name = '', item = '', serial = '', part = '', type = '') {
            const componentList = document.getElementById('component-list');
            const componentHtml = `
                <div class="row g-3 gx-gs mb-5" id="component_${componentIndex}">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][name]" class="form-label">Model</label>
                            <input type="text" class="form-control @error('') is-invalid @enderror" name="components[${componentIndex}][name]" value="${name}" placeholder="HP, DELL, IBM..." required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][item]" class="form-label">Component</label>
                            <input type="text" class="form-control @error('') is-invalid @enderror" name="components[${componentIndex}][item]" value="${item}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][serial]" class="form-label">Serial Number</label>
                            <input type="text" class="form-control @error('') is-invalid @enderror" name="components[${componentIndex}][serial]" value="${serial}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][part]" class="form-label">Part Number</label>
                            <input type="text" class="form-control @error('') is-invalid @enderror" name="components[${componentIndex}][part]" value="${part}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][type]" class="form-label">Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="components[${componentIndex}][type]" required>
                                    @foreach($component_types as $type)
                                        <option value="{{ $type->value }}" ${type === '{{ $type->value }}' ? 'selected' : ''}>{{ ucfirst($type->label) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 gx-gs mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-danger mt-4" onclick="removeComponent(${componentIndex})">Remove Component</button>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-5">
                </div>`;
            componentList.insertAdjacentHTML('beforeend', componentHtml);
            componentIndex++;
        }

        function removeComponent(index) {
            const component = document.getElementById(`component_${index}`);
            if (component) {
                component.remove();
            }
        }

        // Reconstruct the components if validation failed
        @if(old('components'))
            @foreach(old('components') as $index => $component)
                addComponent(
                    '{{ $component['name'] }}',
                    '{{ $component['item'] }}',
                    '{{ $component['serial'] }}',
                    '{{ $component['part'] }}',
                    '{{ $component['type'] }}'
                );
            @endforeach
        @endif

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
        const startDateInput = document.getElementById('warranty_start');
        const endDateInput = document.getElementById('warranty_end');

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

        // if the user wants to take the same date as the contract period disabled the input for date and warranty end
        const sameAsContractCheckbox = document.getElementById('same_as_contract');
        sameAsContractCheckbox.addEventListener('change', function() {
            if (this.checked) {
                startDateInput.disabled = true;
                endDateInput.disabled = true;
            } else {
                startDateInput.disabled = false;
                endDateInput.disabled = false;
            }
        });
</script>
@endsection
