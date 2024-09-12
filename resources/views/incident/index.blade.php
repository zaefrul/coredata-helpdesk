@extends('layouts.main')
@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Incidents</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/incidents">Incident Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Incident list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="/incidents/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/incidents/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Incident</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col">
                                        <span class="overline-title">Incident No</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Title</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Assign to</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Status</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Priority</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Created</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incidents as $incident)
                                    <tr>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                <div class="media-text">
                                                    <a href="/incidents/{{$incident->incident_number}}/show" class="title">{{$incident->incident_number}}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$incident->title}}</td>
                                        <td class="tb-col">
                                            @if($incident->currentAssignee)
                                                @php($assignTo = $incident->currentAssignee)
                                                <div class="media-group">
                                                    <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                        <span class="smaller">{{$assignTo->name[0]}}</span>
                                                    </div>
                                                    <div class="media-text">
                                                        <a href="/users/{{$incident->id}}/show" class="title">{{$assignTo->name}}</a>
                                                        <span class="small text">{{$assignTo->customer ? $assignTo->customer->company_name : ''}}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge text-bg-primary">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($incident->status == 'open')
                                                <span class="badge text-bg-light">Open</span>
                                            @elseif($incident->status == 'in_progress')
                                                <span class="badge text-bg-info">In Progress</span>
                                            @elseif($incident->status == 'resolved')
                                                <span class="badge text-bg-success">Resolved</span>
                                            @else
                                                <span class="badge text-bg-warning">Closed</span>
                                            @endif
                                        </td>
                                        <td class="tb-col">
                                            @if($incident->priority == 'unasigned')
                                                <span class="badge text-bg-light">Unasigned</span>
                                            @elseif($incident->priority == 'low')
                                                <span class="badge text-bg-info">Low</span>
                                            @elseif($incident->priority == 'medium')
                                                <span class="badge text-bg-warning">Medium</span>
                                            @elseif($incident->priority == 'high')
                                                <span class="badge text-bg-danger-soft">High</span>
                                            @else
                                                <span class="badge text-bg-danger">Critical</span>
                                            @endif
                                        </td>
                                        <td class="tb-col">{{$incident->created_at->diffForHumans()}}</td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="/users/{{$incident->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteCustomer({{$incident->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/users/{{$incident->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($incidents) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No incidence found. You can create incidence in Add Incidence form located at the side menu.</td>
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
            form.action = '/customers/'+id;
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