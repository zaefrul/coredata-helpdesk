@extends('layouts.main')
@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Create New Incident</h1>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('user.incidents.index') }}">Incidents</a></li>
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
                                <form action="{{ route('user.incidents.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="contract_id">Contract</label>
                                                <div class="form-control-wrap">
                                                    <select class="js-select" name="contract_id" id="contract_id">
                                                        <option value="">Select Contract</option>
                                                        @foreach ($contracts as $contract)
                                                            <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}>{{ $contract->contract_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="asset_id">Asset</label>
                                                <div class="form-control-wrap">
                                                    <select name="asset_id" id="asset_id">
                                                        <option value="">Select Asset</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- priority  --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="priority">Priority</label>
                                                <div class="form-control-wrap">
                                                    <select class="js-select" name="priority" id="priority">
                                                        <option value="">Select Priority</option>
                                                        <option value="unasigned" {{ old('priority') == 'unasigned' ? 'selected' : '' }}>Unasigned - Select this if you don't know the priority</option>
                                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - SLA within NBD</option>
                                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium - SLA within 8 hours</option>
                                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - SLA within 4 hours</option>
                                                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical - SLA within 2 hours</option> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 gx-gs mb-3">
                                        
                                    </div>
                                    
                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label " for="title">Issue Summary</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                    <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Issue Description</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start"><em class="icon ni ni-notes-alt"></em></div>
                                                    <textarea class="form-control" name="description" id="description" rows="5">{{old('description')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="site_location">Site Location</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-icon start"><em class="icon ni ni-map-pin"></em></div>
                                                    <input type="text" class="form-control" name="site_location" id="site_location">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- PICTURE --}}
                                    <div class="row g-3 gx-gs mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="attachment" class="form-label">Attachment</label>
                                                <div class="form-input-wrap">
                                                    <input type="file" class="form-control form-control-md" id="attachment" name="attachments[]" multiple>
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
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        assetLocation = [];

        const element = document.getElementById('asset_id');
        const asset_selector = new Choices(element, {
            silent: true,
            allowHTML: false,
            searchEnabled: true,
            placeholder: true,
            placeholderValue: null,
            searchPlaceholderValue: 'Search asset name',
            shouldSort: false,
            removeItemButton: false,
        });

        var contractId = document.getElementById('contract_id');
        contractId.addEventListener('change', function() {
            asset_selector.clearStore();
            var selectedContractId = this.value;
            if(selectedContractId === '') {
                return;
            }
            var url = "{{ route('user.assets.getbycontract', ':contract_id') }}";
            url = url.replace(':contract_id', selectedContractId);

            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var options = [];
                    
                    response.forEach(function(asset) {
                        assetLocation[asset.id] = asset.location;

                        var option = {
                            value: asset.id,
                            label: asset.name,
                            selected: false,
                            disabled: false
                        };
                        options.push(option);
                    });

                    asset_selector.setChoices(options);
                }
            };
            xhr.send();
        });

        var assetId = document.getElementById('asset_id');
        assetId.addEventListener('change', function() {
            var selectedAssetId = this.value;
            if(selectedAssetId === '') {
                return;
            }
            var siteLocation = assetLocation[selectedAssetId];
            var siteLocationInput = document.getElementById('site_location');
            siteLocationInput.value = siteLocation;
        });
    });
</script>
@endsection