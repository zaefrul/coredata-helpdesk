@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Project Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Project Manager</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-edit"></em>
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-edit"></em>
                                        <span>Edit Project</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <h5 class="text-uppercase text-muted">Project Information</h5>
                            <div class="row g-3 gx-gs mb-3">
                                <div class="col-md-6">
                                    <p><strong>Customer:</strong> {{ $project->customer->company_name }} [{{ $project->customer->prefix }}]</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Project Name:</strong> {{ $project->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Project Code:</strong> {{ $project->code }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Project Description:</strong></p>
                                    <p>{{ $project->description }}</p>
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
