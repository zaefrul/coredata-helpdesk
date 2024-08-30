@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content inner">
            <div class="nk-content body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Project</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Project Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add New Project</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('projects.store') }}">
                                @csrf
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id" class="form-label">Customer</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" data-search="true" data-sort="true" id="customer_id" name="customer_id" required>
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->company_name }} [{{$customer->prefix}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_name" class="form-label">Project name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control " id="project_name" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_code" class="form-label">Project code</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-tag"></em></div>
                                                <input type="text" class="form-control" id="project_code" name="code" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_description" class="form-label">Project description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" id="project_description" name="description" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3 g-3 gx-gs">
                                    {{-- submit btn --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Add Project</button>
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
        // Select2
        document.querySelectorAll('.form-control').forEach(function(el) {
            // convert to to uppercase
            el.addEventListener('keyup', function(e) {
                this.value = this.value.toUpperCase();
            });
            el.addEventListener('change', function(e) {
                this.value = this.value.toUpperCase();
            });
        });
    });
</script>
@endsection