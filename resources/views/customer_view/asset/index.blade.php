@extends('layouts.main')

@section('content')
@php($isAdmin = Auth::user()->role == 'admin')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Assets List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/resources">Asset Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Assets list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col">
                                        <span class="overline-title">#</span>
                                    </th>
                                    <th class="tb-col  tb-col-md">
                                        <span class="overline-title">Contract</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Brand</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Model</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">S/N</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Category</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $key=>$asset)
                                    <tr>
                                        <td class="tb-col">{{$key + 1}}</td>
                                        <td class="tb-col  tb-col-md">
                                            <div class="media-group">
                                                <div class="media-text">
                                                    <a href="/user/resources/{{$asset->id}}/show" class="title">{{$asset->contract->contract_name}}</a>
                                                    <span class="small text">{{$asset->contract->contract_number}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$asset->brand}}</td>
                                        <td class="tb-col tb-col-md">{{$asset->name}}</td>
                                        <td class="tb-col"><span class="badge text-bg-info-soft">{{$asset->serial_number}}</span></td>
                                        <td class="tb-col">
                                            {{-- if hardware badge dark soft --}}
                                            @if($asset->category == 'hardware')
                                                <span class="badge text-bg-primary-soft">Hardware</span>
                                            @else
                                                <span class="badge text-bg-secondary-soft">Software</span>
                                            @endif
                                        </td>
                                        @if($isAdmin)
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="/resources/{{$asset->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteCustomer({{$asset->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/resources/{{$asset->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($assets) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No assets found. Please add asset in the create asset form.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/data-tables/data-tables.js"></script>
@endsection