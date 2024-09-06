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
                            <form method="POST" action="{{ route('assets.store') }}">
                                @csrf
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_id" class="form-label">Contract</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" data-sort="false" id="contract_id" name="contract_id" required>
                                                    <option>Select Contract</option>
                                                    @foreach($contracts as $contract)
                                                        <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}>{{ $contract->contract_name }} [{{ $contract->contract_number }}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('contract_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Model, Brand, Serial Number, and Category -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Model name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                            </div>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand" class="form-label">Brand name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required>
                                            </div>
                                            @error('brand')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serial_number" class="form-label">Serial Number</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required>
                                            </div>
                                            @error('serial_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Category</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <select class="js-select" data-search="true" data-sort="true" name="category" id="category" required>
                                                    <option>Select Category</option>
                                                    <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                                    <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software</option>
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
                                                <textarea class="form-control" id="details" name="details" required>{{ old('details') }}</textarea>
                                            </div>
                                            @error('details')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchase Date and Warranty End -->
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="purchased_date" class="form-label">Warranty Start</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="date" class="form-control" id="purchased_date" name="purchased_date" value="{{ old('purchased_date') }}" required>
                                            </div>
                                            @error('purchased_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty_end" class="form-label">Warranty End Date</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-calendar"></em></div>
                                                <input type="date" class="form-control" id="warranty_end" name="warranty_end" value="{{ old('warranty_end') }}" required>
                                            </div>
                                            @error('warranty_end')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
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
                            <input type="text" class="form-control" name="components[${componentIndex}][name]" value="${name}" placeholder="HP, DELL, IBM..." required>
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
                                    <option value="hard_disk" ${type === 'hard_disk' ? 'selected' : ''}>Hard Disk</option>
                                    <option value="memory" ${type === 'memory' ? 'selected' : ''}>Memory</option>
                                    <option value="power_supply" ${type === 'power_supply' ? 'selected' : ''}>Power Supply</option>
                                    <option value="pcie" ${type === 'pcie' ? 'selected' : ''}>PCIE</option>
                                    <option value="switch" ${type === 'switch' ? 'selected' : ''}>Switch</option>
                                    <option value="system_board" ${type === 'system_board' ? 'selected' : ''}>System Board</option>
                                    <option value="storage" ${type === 'storage' ? 'selected' : ''}>Storage</option>
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
</script>
@endsection
