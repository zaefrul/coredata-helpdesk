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
                            <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                {{-- incident type --}}
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="incident_type">Incident Type</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" name="incident_type" id="incident_type" required>
                                                    <option value="">Select Incident Type</option>
                                                    <option value="incident" @if(old('incident_type') == 'incident') selected @endif>Incident</option>
                                                    <option value="preventive-maintenance" @if(old('incident_type') == 'preventive-maintenance') selected @endif>Preventive Maintenance</option>
                                                    <option value="schedule-task" @if(old('incident_type') == 'schedule-task') selected @endif>Schedule Task</option>
                                                </select>
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
                                                        @php
                                                            $selected = old('contract_id') == $contract->id ? 'selected' : '';
                                                        @endphp
                                                        <option value="{{ $contract->id }}" {{ $selected }}>{{ $contract->contract_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3 asset-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="asset_id">Asset</label>
                                            <div class="form-control-wrap">
                                                <select name="asset_id" id="asset_id">
                                                    <option value="">Select Asset</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="site_location">Site Location</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-map-pin"></em></div>
                                                <input type="text" class="form-control" name="site_location" id="site_location" value="{{old('site_location')}}">
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
                                {{-- schedule task --}}
                                <div class="row g-3 gx-gs mb-3" id="schedule-task">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="schedule_date">Schedule Date (Require for schedule task)</label>
                                            <div class="form-control-wrap">
                                                <input disabled required type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" id="schedule_date">
                                                @error('schedule_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        assetLocation = [];
        
        queryparam = new URLSearchParams(window.location.search);
        
        var contractid = queryparam.get('contractid');
        var assetid = queryparam.get('assetid');

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
            var selectedContractId = this.value;
            asset_selector.clearStore();
            if(selectedContractId === '' && contractid === null) {
                return;
            }
            else if(selectedContractId === '' && contractid !== null) {
                selectedContractId = contractid;
            }
            var url = "{{ route('staff.assets.getbycontract', ':contract_id') }}";
            url = url.replace(':contract_id', selectedContractId);

            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var options = [];
                    
                    response.forEach(function(asset) {
                        assetLocation[asset.id] = asset.location;

                        var assetName = asset.name;

                        if(asset.serial_number) {
                            assetName += ' [' + asset.serial_number + ']';
                        }

                        var option = {
                            value: asset.id,
                            label: assetName,
                            selected: assetid != null ? assetid == asset.id ? true : false : false,
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

        var incidentType = document.getElementById('incident_type');
        incidentType.addEventListener('change', function() {
            var selectedIncidentType = this.value;
            var scheduleDate = document.getElementById('schedule_date');
            if(selectedIncidentType !== 'incident') {
                scheduleDate.disabled = false;
            } else {
                scheduleDate.disabled = true;
            }
            asset_row = document.querySelector('.asset-row');
            if(selectedIncidentType === 'preventive-maintenance')
            {
                // disabled asset
                asset_row.style.display = 'none';
            }
            else {
                asset_row.style.display = 'block';
            }
        });

        // trigger change so that asset id can be set
        if(contractid) {
            contractId.value = contractid;
            var event = new Event('change');
            contractId.dispatchEvent(event);
        }
    });
</script>
@endsection