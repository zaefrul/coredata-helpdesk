@extends('layouts.main')


@section('content')
@php
    $isAdmin = Auth::user()->role == 'admin';
@endphp

<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Project List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/contracts">Project Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Project list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            @if($isAdmin)
                            <ul class="d-flex">
                                <li>
                                    <a href="/contracts/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/contracts/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Contract</span>
                                    </a>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col tb-col-md">
                                        <span class="overline-title">Contract Name</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Contract Number</span>
                                    </th>
                                    <th class="tb-col tb-col-md">
                                        <span class="overline-title">Start Date</span>
                                    </th>
                                    <th class="tb-col tb-col-md">
                                        <span class="overline-title">End Date</span>
                                    </th>
                                    {{-- header untuk phone --}}
                                    <th class="tb-col">
                                        <span class="overline-title">Period</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Status</span>
                                    </th>
                                    @if($isAdmin)
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $contract)
                                    <tr>
                                        <td class="tb-col tb-col-md">
                                            <div class="media-group">
                                                {{-- <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                    <span class="smaller">{{$contract->project->prefix}}</span>
                                                </div> --}}
                                                <div class="media-text">
                                                    <a href="/contracts/{{$contract->id}}/show" class="title">{{$contract->contract_name}}</a>
                                                    <span class="small text">{{$contract->customer->company_name ?? ''}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$contract->contract_number}}</td>
                                        <td class="tb-col tb-col-md">{{$contract->start_date->format('d-M-Y')}}</td>
                                        <td class="tb-col tb-col-md">{{$contract->end_date->format('d-M-Y')}}</td>
                                        {{-- value untuk phone --}}
                                        <td class="tb-col">
                                            @php
                                                // Number of total days
                                                $totalDays = $contract->start_date->diffInDays($contract->end_date);

                                                // Calculate years, months, and days
                                                $years = floor($totalDays / 365);
                                                $remainingDaysAfterYear = $totalDays % 365;
                                                $months = floor($remainingDaysAfterYear / 30);
                                                $days = $remainingDaysAfterYear % 30;

                                            @endphp
                                            {{-- show different in human form --}}
                                            @if($years > 0)
                                                {{$years}} year{{ $years > 1 ? 's' : ''}}
                                            @endif
                                            @if($months > 0)
                                                {{$months}} month{{ $months > 1 ? 's' : ''}}
                                            @endif
                                            @if($days > 0)
                                                {{$days}} day{{ $days > 1 ? 's' : ''}}
                                            @endif
                                        </td>
                                        <td class="tb-col">
                                            {{-- if date < end_date show active --}}
                                            @if($contract->start_date > now())
                                                <span class="badge text-bg-primary">Upcoming</span>
                                            @elseif($contract->end_date < now())
                                                <span class="badge text-bg-danger">Expired</span>
                                            @else
                                                <span class="badge text-bg-success">Active</span>
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
                                                                <a href="/contracts/{{$contract->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteCustomer({{$contract->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/contracts/{{$contract->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($contracts) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">No contracts found. Please add a contract in the create form.</td>
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
<script>
    // function for a tag onclick event to delete customer
    function deleteCustomer(id) {
        event.preventDefault();
        if(confirm('Are you sure you want to delete this customer?')) {
            // create form and submit as destroy method
            let form = document.createElement('form');
            form.action = '/contracts/'+id;
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection