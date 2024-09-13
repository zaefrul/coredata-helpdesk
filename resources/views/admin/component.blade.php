@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Administrator Control Panel</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/resources">Admin Control Panel</a></li>
                                    </ol>
                                </nav>
                        </div>
                        
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-row card-row-lg col-sep col-sep-lg">
                            <div class="card-aside" >
                                <div class="card-body">
                                    <div class="bio-block">
                                        <div class="bio-body">
                                            <h6 class="overline-title">Add Component Type</h6>
                                            <form action="{{ route('components.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group mt-3">
                                                    <label class="form-label" for="label">Component Type</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-control-icon start">
                                                            <em class="icon ni ni-tag"></em>
                                                        </div>
                                                        <input type="text" class="form-control" id="label" name="label" placeholder="Component Type Name">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info btn-sm mt-1">
                                                    <em class="icon ni ni-save"></em>
                                                    <span>Save</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content col-sep">
                                <div class="card-body">
                                    <div class="bio-block">
                                        <div class="bio-body">
                                            <table class="datatable-init table" data-nk-container="table-responsive">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="tb-col">
                                                            <span class="overline-title">Component</span>
                                                        </th>
                                                        <th class="tb-col tb-col-xxl">
                                                            <span class="overline-title">Created</span>
                                                        </th>
                                                        <th class="tb-col tb-col-end" data-sortable="false">
                                                            <span class="overline-title">Action</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($component_types as $component_type)
                                                    <tr>
                                                        <td class="tb-col">{{ $component_type->label }}</td>
                                                        <td class="tb-col">{{ $component_type->created_at->diffForHumans() }}</td>
                                                        <td class="tb-col"> 
                                                            <a href="{{ route('admin.components.edit', $component_type->id) }}" class="btn btn-sm btn-info">
                                                                <em class="icon ni ni-edit"></em>
                                                            </a>
                                                            <form action="{{ route('components.destroy', $component_type->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                                                    <em class="icon ni ni-trash"></em>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection