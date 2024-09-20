@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content inner">
            <div class="nk-content body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Asset</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Asset Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Asset</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <pre>
                                @if(old())
                                    {{ print_r(old()) }}
                                @endif
                                @if($errors->any())
                                    {{ print_r($errors->all()) }}
                                @endif
                                @if(session()->has('error'))
                                    {{ session('error') }}
                                @endif
                            </pre>
                            <form method="POST" action="{{ route('assets.update', $asset->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract_id" class="form-label">Contract</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" data-sort="false" id="contract_id" name="contract_id" required>
                                                    <option value="">Select Contract</option>
                                                    @foreach($contracts as $contract)
                                                        <option value="{{ $contract->id }}" {{$asset->contract_id == $contract->id ? 'selected' : ''}}>{{ $contract->contract_name }} [{{$contract->contract_number}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Model Name / Software Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control " id="name" name="name" value="{{$asset->name}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand" class="form-label">Brand name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                <input type="text" class="form-control" id="brand" name="brand" value="{{$asset->brand}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serial_number" class="form-label">Serian Number / Software Contract Number</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$asset->serial_number}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Category</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <select class="js-select" data-search="true" data-sort="false" name="category" id="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="hardware" {{$asset->category == 'hardware' ? 'selected' : ''}}>Hardware</option>
                                                    <option value="software" {{old('category', $asset->category) == 'software' ? 'selected' : ''}}>Software</option>
                                                    <option value="service" {{ old('category', $asset->category) == 'service' ? 'selected' : '' }}>service</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="details" class="form-label">Asset description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" id="details" name="details">{{$asset->details}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty_level" class="form-label">Warranty Level</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" id="warranty_level" name="warranty_level" required>
                                                    <option value="">Select Warranty Level</option>
                                                    <option value="third-party" {{ old('warranty_level', $asset->warranty_level) == 'third-party' ? 'selected' : '' }}>3rd Party</option>
                                                    <option value="back-to-back" {{ old('warranty_level', $asset->warranty_level) == 'back-to-back' ? 'selected' : '' }}>Back to Back</option>
                                                </select>
                                            </div>
                                            @error('warranty_level')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Warranty Period</label>
                                            <div class="input-group custom-datepicker" data-range="init" >
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" id="warranty_start" name="purchased_date" value="{{ old('purchased_date', $asset->purchased_date->format('d/m/Y')) }}">
                                                <span class="input-group-text">to</span>
                                                <input  placeholder="dd/mm/yyyy" data-format="dd/mm/yyyy" type="text" class="form-control" id="warranty_end" name="warranty_end" value="{{ old('warranty_end', $asset->warranty_end->format('d/m/Y')) }}">
                                                <span class="input-group-text" id="how-many-month-days">{{$asset->purchased_date->diffInDays($asset->warranty_end)}} day{s}</span>
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
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $asset->location) }}" /ß>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 gx-gs mb-3 mt-3">
                                    <div class="col-12">
                                        <h5>Asset Components</h5>
                                        <div id="component-list">
                                            <!-- Existing components -->
                                            @foreach($asset->components as $index => $component)
                                                <div class="row g-3 gx-gs mb-5" id="component_{{ $index }}">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][name]" class="form-label">Model</label>
                                                            <input type="text" class="form-control" name="components[{{ $index }}][name]" value="{{ old("components.$index.name", $component->component_model) }}" required>
                                                            <input type="hidden" name="components[{{ $index }}][id]" value="{{ $component->id }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][item]" class="form-label">Component</label>
                                                            <input type="text" class="form-control" name="components[{{ $index }}][item]" value="{{ old("components.$index.item", $component->component_name) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][serial]" class="form-label">Serial Number</label>
                                                            <input type="text" class="form-control" name="components[{{ $index }}][serial]" value="{{ old("components.$index.serial", $component->serial_number) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][part]" class="form-label">Part Number</label>
                                                            <input type="text" class="form-control" name="components[{{ $index }}][part]" value="{{ old("components.$index.part", $component->part_number) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][type]" class="form-label">Type</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select" name="components[{{ $index }}][type]" required>
                                                                    <option value="">Select component type</option>
                                                                    @foreach($component_types as $component_type)
                                                                        <option value="{{ $component_type->value }}" {{ old("components.$index.type", $component->component_type) == $component_type->value ? 'selected' : '' }}>{{ ucfirst($component_type->label) }}</option>
                                                                    @endforeach
                                                                    <!-- Add other types as needed -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 gx-gs mb-3">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-outline-danger mt-4" onclick="removeComponent({{ $index }})">Remove Component</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-5">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" onclick="addComponent()">Add Component</button>
                                    </div>
                                </div>
                                {{-- end asset components --}}
                                <div class="row g-3 gx-gs mb-3">
                                    {{-- submit btn --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <em class="icon ni ni-save"></em> <span class="ml-1">Save</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger">
                                                <em class="icon ni ni-cross"></em> <span class="ml-1">Cancel</span>
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


    let componentIndex = {{ $asset->components->count() }};

        function addComponent(name = '', item = '', serial = '', part = '', type = '') {
            const componentList = document.getElementById('component-list');
            const componentTypeOptions = `@foreach($component_types as $component_type)
                <option value="{{ $component_type->value }}" ${type === '{{$component_type->value}}' ? 'selected' : ''}>{{ ucfirst($component_type->label) }}</option>
            @endforeach`;
            const componentHtml = `
                <div class="row g-3 gx-gs mb-5" id="component_${componentIndex}">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][name]" class="form-label">Model</label>
                            <input type="text" class="form-control" name="components[${componentIndex}][name]" value="${name}" placeholder="HP, DELL, IBM..." required>
                            <input type="hidden" name="components[${componentIndex}][id]" value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][item]" class="form-label">Component</label>
                            <input type="text" class="form-control" name="components[${componentIndex}][item]" value="${item}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][serial]" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" name="components[${componentIndex}][serial]" value="${serial}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][part]" class="form-label">Part Number</label>
                            <input type="text" class="form-control" name="components[${componentIndex}][part]" value="${part}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][type]" class="form-label">Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="components[${componentIndex}][type]" required>
                                    <option value="">Select component type</option>
                                    ${componentTypeOptions}
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

        // Reconstruct additional components if validation failed
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
</script>
@endsection