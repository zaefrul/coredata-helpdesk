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
                                                @if($incident->currentAssignee)
                                                    <a class="text-decoration-none link-info" href="#" aria-expanded="false">{{$incident->currentAssignee->name}}</a>
                                                @else
                                                    Unassigned
                                                @endif
                                            </li>
                                            <li class="list-group-item" style="display: flex">
                                                <div class="title fw-medium w-40 d-inline-block">Reporter</div>
                                                <div class="text">
                                                    @if($incident->user)
                                                        {{-- {{$incident->user->name}} --}}
                                                        {{-- uppercase each word --}}
                                                        {{-- {{ucwords(strtolower($incident->user->name))}} --}}
                                                        {{-- truncate to two words --}}
                                                        <a href="{{route('user.accounts.show', $incident->user->id)}}">{{implode(' ', array_slice(explode(' ', $incident->user->name), 0, 2))}}</a>
                                                    @else
                                                        Unassigned
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="display: flex;">
                                                <div class="title fw-medium w-40 d-inline-block">Status</div>
                                                <div class="text">
                                                    @if($incident->status == 'open')
                                                        <span class="badge text-bg-info fs-6">Open</span>
                                                    @elseif($incident->status == 'closed')
                                                        <span class="badge text-bg-warning fs-6">Closed</span>
                                                    @elseif($incident->status == 'in_progress')
                                                        <span class="badge text-bg-info fs-6">In Progress</span>
                                                    @elseif($incident->status == 'resolved')
                                                        <span class="badge text-bg-success fs-6">Resolved</span>
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="display: flex;">
                                                <div class="title fw-medium w-40 d-inline-block">Priority</div>
                                                <div class="text">
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
                                        <form method="POST" action="{{route('user.incident.comment', ['incident' => $incident->id])}}">
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

                                        {{-- asset info --}}
                                        <div class="row g-gs mt-1">
                                            <div class="col-lg-12">
                                                <div class="small">Asset / Software Name</div>
                                                <h5 class="small">{{$incident->asset->name}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-6">
                                                <div class="small">Serial Number</div>
                                                <h5 class="small">{{$incident->asset->serial_number}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Model</div>
                                                <h5 class="small">{{$incident->asset->brand ?? '-'}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Location</div>
                                                <h5 class="small">{{$incident->asset->location ?? '-'}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Category</div>
                                                <h5 class="small">{{ucfirst($incident->asset->category) ?? '-'}}</h5>
                                            </div><!-- .col -->
                                        </div><!-- .row -->

                                        <div class="row mt-3">
                                            <div class="col-lg-3">
                                                <div class="small">Warranty Level</div>
                                                <h5 class="small">{{ucfirst($incident->asset->warranty_level) ?? '-'}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Warranty Start</div>
                                                <h5 class="small">{{$incident->asset->purchased_date ? $incident->asset->purchased_date->format('d M Y') : '-'}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Warranty End</div>
                                                <h5 class="small">{{$incident->asset->warranty_end ? $incident->asset->warranty_end->format('d M Y') : '-'}}</h5>
                                            </div><!-- .col -->
                                            <div class="col-lg-3">
                                                <div class="small">Warranty Status</div>
                                                <h5 class="small">
                                                    @if($incident->asset->warranty_end && $incident->asset->warranty_end->isPast())
                                                        <span class="badge text-bg-danger">Expired</span>
                                                    @else
                                                        <span class="badge text-bg-success">Active</span>
                                                    @endif
                                                </h5>
                                            </div><!-- .col -->
                                        </div>

                                    </div><!-- .bio-block -->
                                </div><!-- .card-body -->
                                <div class="card-body">
                                    <div class="bio-block">
                                        <ul class="nav nav-tabs mb-3 nav-tabs-s1">
                                            <li class="nav-item">
                                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#custom-home-tab-pane" type="button">Recent Activities</button>
                                            </li>
                                            <li class="nav-item">
                                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#custom-profile-tab-pane" type="button">Components</button>
                                            </li>
                                          </ul>
                                          <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="custom-home-tab-pane">
                                                @include('incident._partial.recent_activities', ['activityLogs' => $activityLogs])
                                            </div>
                                            <div class="tab-pane fade" id="custom-profile-tab-pane">
                                                @include('incident._partial.component', ['components' => $incident->asset->components])
                                            </div>
                                          </div>

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