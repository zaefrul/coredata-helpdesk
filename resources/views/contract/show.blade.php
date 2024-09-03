@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Contract Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contract Manager</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Contract Details - {{$contract->code}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_name" class="form-label">Project</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ $contract->customer->company_name }} [{{ $contract->customer->prefix }}]</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contract_name" class="form-label">Contract Name</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ $contract->contract_name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contract_number" class="form-label">Contract Number</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ $contract->contract_number }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($contract->start_date)->format('Y-m-d') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($contract->end_date)->format('Y-m-d') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- row for incident --}}
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="incident" class="form-label">Number of Incident</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">
                                                @if($contract->total_incidence == -1)
                                                    <span class="badge text-bg-info">Unlimited</span>
                                                @elseif($contract->total_incidence == 0)
                                                    <span class="badge text-bg-danger">None</span>
                                                @else
                                                    {{ $contract->total_incidence }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- row for preventive maintenance --}}
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="preventive_maintenance" class="form-label">Preventive Maintenance</label>
                                        <div class="form-control-wrap">
                                            @if($contract->preventive_maintenance > 0)
                                                <p class="form-control-plaintext">Yes</p>({{ $contract->preventive_maintenance }})
                                            @else
                                                <p class="form-control-plaintext">No</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- row for corrective maintenance --}}
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="corrective_maintenance" class="form-label">Corrective Maintenance</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ $contract->corrective_maintenance }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <div class="form-control-wrap">
                                            <p class="form-control-plaintext">{{ $contract->details }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 gx-gs mn-3">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row g-3 gx-gs mn-3">
                                <div class="col-md-6">
                                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-primary">Edit Contract</a>
                                    <a href="{{ route('contracts.index') }}" class="btn btn-warning">Back to List</a>
                                </div>
                                <div class="col-md-6 justify-content-end">
                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete Contract</button>
                                    </form>
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
