@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Create Inventory</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/inventories">Inventory Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create Inventory</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('inventories.store') }}" method="POST">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Model</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="model" name="model" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="form-label">Type</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" id="type" data-placeholder="Select a option.." name="type" required>
                                                    @foreach ($component_types as $type)
                                                        <option value="{{ $type->value }}">{{ $type->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>        

                                        {{-- <div class="form-group">
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
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Serial Number</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="sn" name="serial_number" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Part Number</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="pn" name="part_number" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mfg_part_number" class="form-label">MFG Part Number</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="mfg_part_number" name="mfg_part_number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <em class="icon ni ni-save"></em>
                                                Save
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
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>
@endsection