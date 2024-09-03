@extends('layouts.main')

@section('content')
{{-- form to create incident, attributes are (contract_id, asset_id(derived from contract), title, description, site_location if exist --}}
<div class="nk-content">
    <div class="nk-content inner">
        <div class="nk-content body">
            <div class="nk-block-head">
                <div class="nk-block-head-between flex-wrap gap g-2">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title">Create New Incident</h1>
                        <nav>
                            <ol class="breadcrumb breadcrumb-arrow mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Incidents</a></li>
                                <li class="breadcrumb-item active" aria-current="page">New Incident</li>
                            </ol>
                        </nav>
                    </div>
                </div><!-- .nk-block-head-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-body">
                        <div class="card-inner card-inner-lg">
                            <form action="{{ route('incidents.store') }}" method="POST">
                                @csrf
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label " for="title">Title</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                <input type="text" class="form-control" name="title" id="title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-notes-alt"></em></div>
                                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="contract_id">Contract</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" name="contract_id" id="contract_id">
                                                    <option value="">Select Contract</option>
                                                    @foreach ($contracts as $contract)
                                                        <option value="{{ $contract->id }}">{{ $contract->contract_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="asset_id">Asset</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" name="asset_id" id="asset_id">
                                                    <option value="">Select Asset</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="site_location">Site Location</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-map-pin"></em></div>
                                                <input type="text" class="form-control" name="site_location" id="site_location">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Create Incident</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

