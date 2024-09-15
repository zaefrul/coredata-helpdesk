@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="row g-gs">
                    <div class="row g-gs mt-1">
                        <div class="col-md-12 col-xxl-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h5 class="title">Recent Activity</h5>
                                        </div>
                                    </div><!-- .card-title-group -->
                                    <div class="nk-timeline nk-timeline-center mt-4">
                                        <div class="nk-timeline-group">
                                            <div class="nk-timeline-heading">
                                                <h6 class="overline-title">Incidents Activities</h6>
                                            </div>
                                            <ul class="nk-timeline-list">
                                                @foreach($recentActivities as $incident)
                                                    <li class="nk-timeline-item">
                                                        <div class="nk-timeline-item-inner">
                                                            <div class="nk-timeline-symbol">
                                                                @if(str_contains($incident->description, 'Changed'))
                                                                    <div class="media media-md media-middle media-circle text-bg-success">
                                                                        <em class="icon ni ni-arrow-right"></em>
                                                                    </div>
                                                                @elseif(str_contains($incident->description, 'Created'))
                                                                    <div class="media media-md media-middle media-circle text-bg-info">
                                                                        <em class="icon ni ni-user"></em>
                                                                    </div>
                                                                @elseif(str_contains($incident->description, 'Deleted'))
                                                                    <div class="media media-md media-middle media-circle text-bg-danger">
                                                                        <em class="icon ni ni-trash"></em>
                                                                    </div>
                                                                @elseif(str_contains($incident->description, 'Incident assigned'))
                                                                    <div class="media media-md media-middle media-circle text-bg-warning">
                                                                        <em class="icon ni ni-user"></em>
                                                                    </div>
                                                                @elseif(str_contains($incident->description, 'Comment added'))
                                                                    <div class="media media-md media-middle media-circle text-bg-warning">
                                                                        <em class="icon ni ni-note-add"></em>
                                                                    </div>
                                                                @else
                                                                    <div class="media media-md media-middle media-circle text-bg-warning">
                                                                        <em class="icon ni ni-arrow-right"></em>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="nk-timeline-content">
                                                                @if(str_contains($incident->description, 'Comment added'))
                                                                    <p class="small"><strong><a class="link-info" href="/incidents/{{$incident->incident->incident_number}}/show">{{$incident->incident->incident_number}}</a></strong>  - {!! $incident->description !!} by <a href="{{route('users.show', $incident->user->id)}}">{{ $incident->user->name }}</a> - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
                                                                @else
                                                                <p class="small"><strong><a class="link-info" href="/incidents/{{$incident->incident->incident_number}}/show">{{$incident->incident->incident_number}}</a></strong>  - {!! $incident->description !!} - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                @if($recentActivities->count() == 0)
                                                    <li class="nk-timeline-item">
                                                        <div class="nk-timeline-item-inner">
                                                            <div class="nk-timeline-symbol">
                                                                <div class="media media-md media-middle media-circle text-bg-success">
                                                                    <em class="icon ni ni-arrow-right"></em>
                                                                </div>
                                                            </div>
                                                            <div class="nk-timeline-content">
                                                                <p class="small">No recent activities</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- .nk-timeline -->
                                </div><!-- .card-body -->
                            </div><!-- .card -->
                        </div><!-- .col -->

                        <div class="col-xxl-6">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h5 class="title">Recent incidents</h5>
                                        </div>
                                        {{-- <div class="card-tools">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <li>
                                                        <div class="dropdown-header pt-2 pb-0">
                                                            <h6 class="mb-0">Options</h6>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item">7 Days</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item">15 Days</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item">30 Days</a>
                                                    </li>
                                                </ul>
                                            </div><!-- dropdown -->
                                        </div> --}}
                                    </div><!-- .card-title-group -->
                                </div><!-- .card-body -->
                                <div class="table-responsive">
                                    <table class="table table-middle mb-0">
                                        <thead class="table-light table-head-sm">
                                            <tr>
                                                <th class="tb-col">
                                                    <span class="overline-title">Incident Number</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Status</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Priority</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Created</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentIncidents as $incident)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md flex-shrink-0 media-middle media-circle text-bg-primary">
                                                                <em class="icon ni ni-ticket"></em>
                                                            </div>
                                                            <div class="media-text">
                                                                <span class="title">
                                                                    <a href="/incidents/{{$incident->incident_number}}/show" class="link-text"><span class="title">{{$incident->incident_number}}</span></a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        @if($incident->status == 'resolved')
                                                            <span class="badge text-bg-success">Resolved</span>
                                                        @elseif($incident->status == 'in_progress')
                                                            <span class="badge text-bg-warning">In Progress</span>
                                                        @elseif($incident->status == 'closed')
                                                            <span class="badge text-bg-danger">Closed</span>
                                                        @elseif($incident->status == 'open')
                                                            <span class="badge text-bg-info">Open</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        @if($incident->priority == 'low')
                                                            <span class="badge text-bg-info">Low</span>
                                                        @elseif($incident->priority == 'medium')
                                                            <span class="badge text-bg-warning">Medium</span>
                                                        @elseif($incident->priority == 'high')
                                                            <span class="badge text-bg-danger-soft">High</span>
                                                        @elseif($incident->priority == 'critical')
                                                            <span class="badge text-bg-danger">Critical</span>
                                                        @elseif($incident->priority == 'unasigned')
                                                            <span class="badge text-bg-secondary">None</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="small">{{$incident->created_at->diffForHumans()}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if($recentIncidents->count() == 0)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media media-md">
                                                            <div class="media-text">
                                                                <span class="title">No recent incidents</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection