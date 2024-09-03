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
                            <form method="POST" action="{{ route('assets.update', $asset->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_id" class="form-label">Contract</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" data-sort="false" id="contract_id" name="contract_id" required>
                                                    <option>Select Contract</option>
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
                                            <label for="name" class="form-label">Model name</label>
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
                                            <label for="serial_number" class="form-label">Serian Number</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$asset->serial_number}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Category</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <select class="js-select" data-search="true" data-sort="false" name="category" id="category" required>
                                                    <option>Select Category</option>
                                                    <option value="hardware" {{$asset->category == 'hardware' ? 'selected' : ''}}>Hardware</option>
                                                    <option value="software" {{$asset->category == 'software' ? 'selected' : ''}}>Software</option>
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
                                                <textarea class="form-control" id="details" name="details" required>{{$asset->details}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="purchased_date" class="form-label">Warranty Start</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="date" class="form-control" id="purchased_date" name="purchased_date" value="{{$asset->purchased_date->format('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty_end" class="form-label">Warranty Date</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="date" class="form-control" id="warranty_end" name="warranty_end" value="{{$asset->warranty_end->format('Y-m-d')}}" required>
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
                                                            <input type="text" class="form-control" name="components[{{ $index }}][part]" value="{{ old("components.$index.part", $component->part_number) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="components[{{ $index }}][type]" class="form-label">Type</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select" name="components[{{ $index }}][type]" required>
                                                                    <option>Select component type</option>
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
                            <input type="text" class="form-control" name="components[${componentIndex}][part]" value="${part}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="components[${componentIndex}][type]" class="form-label">Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="components[${componentIndex}][type]" required>
                                    <option>Select component type</option>
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
</script>
@endsection