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
                                    <div class="bio-block">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="dropzoneFile1" class="form-label">Upload File/Attachment</label>
                                                <div class="form-control-wrap">
                                                    <div id="dropzoneFile1" data-url="{{route('incident.attachment')}}">
                                                        <div class="dz-message" data-dz-message>
                                                            <div class="dz-message-icon"></div>
                                                            <span class="dz-message-text">Drag and drop file</span>
                                                            <div class="dz-message-btn mt-2">
                                                                <button class="btn btn-md btn-primary">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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

                                        @include('incident._partial.asset_row', ['asset' => $incident->asset])

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

@section('js')
<script src="/assets/js/data-tables/data-tables.js"></script>
<script>
        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = '/inventories/' + id + '/delete';
            }
        }

        let itemId = item.id;
        let maxFiles = item.dataset.maxFiles ? parseInt(item.dataset.maxFiles) : null;
        let maxFilesize = item.dataset.maxFilesize ? parseInt(item.dataset.maxFilesize) : 256;
        let messageIcon = item.dataset.messageIcon ? item.dataset.messageIcon : ((maxFiles === 1) ? 'file' : 'files');
        let acceptedFiles = item.dataset.acceptedFiles ? item.dataset.acceptedFiles : null;

        //add styling Class 
        item.classList.add('dropzone');
        let dzFileSize = item.querySelector('.dz-message-text');
        item.dataset.maxFilesize && dzFileSize.insertAdjacentHTML('beforeend', `<small>Max ${maxFilesize} MiB</small>`);
        //filesize
        
        //icon
        let dzIcon = item.querySelector('.dz-message-icon:empty');
        let dzIconMarkUp = `<em class="icon icon-lg ni ni-${messageIcon}"></em>`
        dzIcon ? dzIcon.innerHTML = dzIconMarkUp : null;
        let myDropzone = new Dropzone(`#${itemId}`,{
            url: "image",
            maxFilesize: maxFilesize,
            maxFiles: maxFiles,
            acceptedFiles: acceptedFiles
        });
</script>
@endsection