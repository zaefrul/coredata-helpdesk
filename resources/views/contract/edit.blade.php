@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content inner">
            <div class="nk-content body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Contract</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('contracts.index') }}">Contract Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Contract</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('contracts.update', $contract->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_id" class="form-label required">Project</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" data-sort="true" id="project_id" name="project_id" required>
                                                    <option value="">Select Project</option>
                                                    @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" {{$contract->project_id == $project->id ? 'selected' : ''}}>{{ $project->name }} [{{$project->code}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_name" class="form-label required">Contract Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control" id="contract_name" name="name" value="{{$contract->contract_name}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label required">Contract Number</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control " id="code" name="code" value="{{$contract->code}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date" class="form-label required">Start Date</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control " id="start_date" name="start_date" value="{{$contract->start_date->format('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label required">End Date</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control " id="end_date" name="end_date" value="{{$contract->end_date->format('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_value" class="form-label required">Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" id="description" name="description" required>{{$contract->details}}</textarea>
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
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save Information</button>
                                        <a href="{{ route('contracts.index') }}" class="btn btn-warning">Cancel</a>
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