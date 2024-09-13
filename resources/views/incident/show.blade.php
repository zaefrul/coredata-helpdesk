@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-row card-row-lg col-sep col-sep-lg">
                            <div class="card-aside" >
                                <div class="card-body">
                                    <div class="bio-block">
                                        <h4 class="bio-block-title">Details</h4>
                                        <ul class="list-group list-group-borderless small">
                                            <li class="list-group-item">
                                                <span class="title fw-medium w-40 d-inline-block">Ticket ID</span>
                                                <span class="text">{{$incident->incident_number}}</span>
                                            </li>
                                            <li class="list-group-item" style="display: flex;">
                                                <div class="title fw-medium w-40 d-inline-block">Assignee</div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-decoration-none link-info" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if($incident->currentAssignee)
                                                            {{$incident->currentAssignee->name}}
                                                        @else
                                                            Unassigned
                                                        @endif
                                                    </a>
                                        
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @foreach($agents as $agent)
                                                            <li>
                                                                <form method="POST" action="{{ route('incident.assign', ['incident' => $incident->id]) }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="assignee_id" value="{{ $agent->id }}">
                                                                    <button type="submit" class="dropdown-item">{{ $agent->name }}</button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="display: flex">
                                                <div class="title fw-medium w-40 d-inline-block">Reporter</div>
                                                <div class="text">
                                                    @if($incident->user)
                                                        {{-- {{$incident->user->name}} --}}
                                                        {{-- uppercase each word --}}
                                                        {{-- {{ucwords(strtolower($incident->user->name))}} --}}
                                                        {{-- truncate to two words --}}
                                                        <a href="{{route('users.show', $incident->user->id)}}">{{implode(' ', array_slice(explode(' ', $incident->user->name), 0, 2))}}</a>
                                                    @else
                                                        Unassigned
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="display: flex;">
                                                <div class="title fw-medium w-40 d-inline-block">Status</div>
                                                <div class="text">
                                                    <a class="dropdown-toggle text-decoration-none link-info" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if($incident->status == 'open')
                                                            <span class="badge text-bg-info fs-6">Open</span>
                                                        @elseif($incident->status == 'closed')
                                                            <span class="badge text-bg-warning fs-6">Closed</span>
                                                        @elseif($incident->status == 'in_progress')
                                                            <span class="badge text-bg-info fs-6">In Progress</span>
                                                        @elseif($incident->status == 'resolved')
                                                            <span class="badge text-bg-success fs-6">Resolved</span>
                                                        @endif
                                                    </a>

                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.status', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="open">
                                                                <button type="submit" class="dropdown-item">Open</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.status', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="in_progress">
                                                                <button type="submit" class="dropdown-item">In Progress</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.status', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="dropdown-item">Resolved</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.status', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="closed">
                                                                <button type="submit" class="dropdown-item">Closed</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="display: flex;">
                                                <div class="title fw-medium w-40 d-inline-block">Priority</div>
                                                <div class="text">
                                                    <a class="dropdown-toggle text-decoration-none link-info" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if($incident->priority == 'low')
                                                            <span class="badge text-bg-info fs-6">Low <em class="icon ni ni-chevrons-down"></em></span>
                                                        @elseif($incident->priority == 'medium')
                                                            <span class="badge text-bg-warning fs-6">Medium <em class="icon ni ni-chevron-down"></em></span>
                                                        @elseif($incident->priority == 'high')
                                                            <span class="badge text-bg-danger-soft fs-6">High <em class="icon ni ni-chevron-up"></em></span>
                                                        @elseif($incident->priority == 'critical')
                                                            <span class="badge text-bg-danger fs-6">Critical <em class="icon ni ni-chevrons-up"></em></span>
                                                        @else
                                                            <span class="badge text-bg-light fs-6">Unassigned</span>
                                                        @endif
                                                    </a>

                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.priority', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="priority" value="low">
                                                                <button type="submit" class="dropdown-item">Low</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.priority', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="priority" value="medium">
                                                                <button type="submit" class="dropdown-item">Medium</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.priority', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="priority" value="high">
                                                                <button type="submit" class="dropdown-item">High</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('incident.priority', ['incident' => $incident->id]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="priority" value="critical">
                                                                <button type="submit" class="dropdown-item">Critical</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="title fw-medium w-40 d-inline-block">Created</span>
                                                <span class="text">
                                                    {{$incident->created_at->diffForHumans()}}
                                                </span>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="title fw-medium w-40 d-inline-block">Updated</span>
                                                <span class="text">
                                                    {{$incident->updated_at->diffForHumans()}}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bio-block">
                                        <form method="POST" action="{{route('incident.comment', ['incident' => $incident->id])}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="comment" class="form-label">Comment</label>
                                                <div class="form-input-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-comment"></em>
                                                    </div>
                                                    <textarea class="form-control form-control-sm" id="comment" name="comment" placeholder="Write a comment"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-light btn-sm">Add Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- .card-body -->
                            </div>
                            <div class="card-content col-sep">
                                <div class="card-body">
                                    <div class="bio-block">
                                        <h4 class="bio-block-title">{{$incident->title}}</h4>
                                        <p>{{$incident->description}}</p>
                                        
                                        <div class="row g-gs">
                                            <div class="col-lg-12">
                                                <div class="small">Contract</div>
                                                <h5 class="small">{{$incident->contract->contract_name}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-12">
                                                <div class="small">Customer</div>
                                                <h5 class="small">{{$incident->customer->company_name}} [{{$incident->customer->prefix}}]</h5>
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div><!-- .bio-block -->
                                </div><!-- .card-body -->
                                <div class="card-body">
                                    <div class="bio-block">
                                        <h4 class="bio-block-title">Recent Activity</h4>
                                        <ul class="nk-schedule mt-4">
                                            @foreach($activityLogs as $activityLog)
                                                <li class="nk-schedule-item">
                                                    <div class="nk-schedule-item-inner">
                                                        <div class="nk-schedule-symbol active"></div>
                                                        <div class="nk-schedule-content">
                                                            <span class="smaller">{{$activityLog->created_at->diffForHumans()}}</span>
                                                            <div class="h6">
                                                                @php
                                                                    $activityLog->description = str_replace(
                                                                        ["'open'", "'in_progress'", "'resolved'", "'closed'"],
                                                                        [
                                                                            '<span class="badge text-bg-info fs-6">Open</span>',
                                                                            '<span class="badge text-bg-info fs-6">In Progress</span>',
                                                                            '<span class="badge text-bg-success fs-6">Resolved</span>',
                                                                            '<span class="badge text-bg-warning fs-6">Closed</span>'
                                                                        ],
                                                                        $activityLog->description
                                                                    );

                                                                    $activityLog->description = str_replace(
                                                                        ["'low'", "'medium'", "'high'", "'critical'"],
                                                                        [
                                                                            '<span class="badge text-bg-info fs-6">Low <em class="icon ni ni-chevrons-down"></em></span>',
                                                                            '<span class="badge text-bg-warning fs-6">Medium <em class="icon ni ni-chevron-down"></em></span>',
                                                                            '<span class="badge text-bg-danger-soft fs-6">High <em class="icon ni ni-chevron-up"></em></span>',
                                                                            '<span class="badge text-bg-danger fs-6">Critical <em class="icon ni ni-chevrons-up"></em></span>'
                                                                        ],
                                                                        $activityLog->description
                                                                    );
                                                                @endphp
                                                                {{-- print description html --}}
                                                                {!! $activityLog->description !!}
                                                            </div>
                                                            @if($activityLog->comment)
                                                                <div class="alert alert-info mt-2" role="alert">
                                                                    <div class="d-flex">
                                                                        <em class="icon icon-lg ni ni-user-round"></em>
                                                                        <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                                                            <div>
                                                                                <h6 class="alert-heading mb-0">{{$activityLog->user->name}} commented:</h6>
                                                                                <span class="smaller">{{$activityLog->comment}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div><!-- .bio-block -->
                                </div><!-- .card-body -->
                            </div><!-- .card-content -->
                        </div><!-- .card-row -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection