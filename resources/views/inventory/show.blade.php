@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Inventory</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/inventories">Inventory Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Inventory</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Model</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="model" name="model" value="{{old('model', $inventory->model)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="form-label">Type</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="model" name="model" value="{{old('model', \App\Helper\SettingHelper::getLabelValue('component_type', $inventory->type))}}">
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
                                            <label class="form-label">Item</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="item" name="item" value="{{ old('item', $inventory->item) }}">
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Serial Number</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="sn" name="serial_number" value="{{ old('serial_numbner', $inventory->serial_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Part Number</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="pn" name="part_number" value="{{ old('part_number', $inventory->part_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mfg_part_number" class="form-label">MFG Part Number</label>
                                            <div class="form-control-wrap">
                                                <input disabled type="text" class="form-control" id="mfg_part_number" name="mfg_part_number" value="{{ old('mfg_part_number', $inventory->mfg_part_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a href="/inventories/{{$inventory->id}}/edit" class="btn btn-warning">
                                                <em class="icon ni ni-edit" style="margin-right: 0.5rem"></em>
                                                Edit
                                            </a>
                                            <form action="/inventories/{{$inventory->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <em class="icon ni ni-trash" style="margin-right: 0.5rem"></em>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection