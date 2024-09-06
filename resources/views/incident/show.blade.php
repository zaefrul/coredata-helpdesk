@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="tab-1" tabindex="0">
                            <div class="card card-gutter-md">
                                <div class="card-row card-row-lg col-sep col-sep-lg">
                                    <div class="card-aside">
                                        <div class="card-body">
                                            <div class="bio-block">
                                                <h4 class="bio-block-title">Details</h4>
                                                <ul class="list-group list-group-borderless small">
                                                    <li class="list-group-item">
                                                        <span class="title fw-medium w-40 d-inline-block">Ticket ID</span>
                                                        <span class="text">{{$incident->incident_number}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="title fw-medium w-40 d-inline-block">Assignee</span>
                                                        <span class="text">
                                                            @if($incident->currentAssignee)
                                                                {{$incident->currentAssignee->name}}
                                                            @else
                                                                Unassigned
                                                            @endif
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="title fw-medium w-40 d-inline-block">Reporter</span>
                                                        <span class="text">
                                                            @if($incident->user)
                                                                {{$incident->user->name}}
                                                            @else
                                                                Unassigned
                                                            @endif
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="title fw-medium w-40 d-inline-block">Status</span>
                                                        <span class="text">
                                                            @if($incident->status == 'open')
                                                                <span class="badge text-bg-info fs-6">Open</span>
                                                            @elseif($incident->status == 'closed')
                                                                <span class="badge text-bg-warning fs-6">Closed</span>
                                                            @elseif($incident->status == 'in_progress')
                                                                <span class="badge text-bg-info fs-6">In Progress</span>
                                                            @elseif($incident->status == 'resolved')
                                                                <span class="badge text-bg-success fs-6">Resolved</span>
                                                            @endif
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="title fw-medium w-40 d-inline-block">Priority</span>
                                                        <span class="text">
                                                            @if($incident->priority == 'low')
                                                                <span class="badge text-bg-info fs-6">Low <em class="icon ni ni-chevrons-down"></em></span>
                                                            @elseif($incident->priority == 'medium')
                                                                <span class="badge text-bg-warning fs-6">Medium <em class="icon ni ni-chevron-down"></em></span>
                                                            @elseif($incident->priority == 'high')
                                                                <span class="badge text-bg-danger-soft fs-6">High <em class="icon ni ni-chevron-up"></em></span>
                                                            @elseif($incident->priority == 'critical')
                                                                <span class="badge text-bg-danger fs-6">Critical <em class="icon ni ni-chevrons-up"></em></span>
                                                            @endif
                                                        </span>
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
                                            </div><!-- .bio-block -->
                                            {{-- <div class="bio-block">
                                                <h4 class="bio-block-title mb-2">Skills</h4>
                                                <ul class="d-flex flex-wrap gap gx-1">
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">Photoshop</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">illustrator</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">HTML</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">CSS</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">Javascript</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">React</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">Vue</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">Angular</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="badge text-bg-secondary-soft">Python</a>
                                                    </li>
                                                </ul>
                                            </div><!-- .bio-block -->
                                            <div class="bio-block">
                                                <h4 class="bio-block-title mb-3">Social</h4>
                                                <ul class="d-flex flex-wrap gap g-2">
                                                    <li>
                                                        <a href="#" class="media media-sm media-middle text-bg-dark">
                                                            <em class="icon ni ni-github-circle"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="media media-sm media-middle text-bg-danger">
                                                            <em class="icon ni ni-dribbble"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="media media-sm media-middle text-bg-info">
                                                            <em class="icon ni ni-twitter"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="media media-sm media-middle text-bg-pink">
                                                            <em class="icon ni ni-linkedin"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div><!-- .bio-block --> --}}
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
                                                    <li class="nk-schedule-item">
                                                        <div class="nk-schedule-item-inner">
                                                            <div class="nk-schedule-symbol active"></div>
                                                            <div class="nk-schedule-content">
                                                                <span class="smaller">2:12 PM</span>
                                                                <div class="h6">Added 3 New Images</div>
                                                                <ul class="d-flex flex-wrap gap g-2 py-2">
                                                                    <li>
                                                                        <div class="media media-xxl">
                                                                            <img src="./images/product/a.jpg" alt="" class="img-thumbnail">
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="media media-xxl">
                                                                            <img src="./images/product/b.jpg" alt="" class="img-thumbnail">
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="media media-xxl">
                                                                            <img src="./images/product/c.jpg" alt="" class="img-thumbnail">
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nk-schedule-item">
                                                        <div class="nk-schedule-item-inner">
                                                            <div class="nk-schedule-symbol active"></div>
                                                            <div class="nk-schedule-content">
                                                                <span class="smaller">4:23 PM</span>
                                                                <div class="h6">Invitation for creative designs pattern</div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nk-schedule-item">
                                                        <div class="nk-schedule-item-inner">
                                                            <div class="nk-schedule-symbol active"></div>
                                                            <div class="nk-schedule-content nk-schedule-content-no-border">
                                                                <span class="smaller">10:30 PM</span>
                                                                <div class="h6">Task report - uploaded weekly reports</div>
                                                                <div class="list-group-dotted mt-3">
                                                                    <div class="list-group-wrap">
                                                                        <div class="p-3">
                                                                            <div class="media-group">
                                                                                <div class="media rounded-0">
                                                                                    <img src="./images/icon/file-type-pdf.svg" alt="">
                                                                                </div>
                                                                                <div class="media-text ms-1">
                                                                                    <a href="#" class="title">Modern Designs Pattern</a>
                                                                                    <span class="text smaller">1.6.mb</span>
                                                                                </div>
                                                                            </div><!-- .media-group -->
                                                                        </div>
                                                                        <div class="p-3">
                                                                            <div class="media-group">
                                                                                <div class="media rounded-0">
                                                                                    <img src="./images/icon/file-type-doc.svg" alt="">
                                                                                </div>
                                                                                <div class="media-text ms-1">
                                                                                    <a href="#" class="title">cPanel Upload Guidelines</a>
                                                                                    <span class="text smaller">18kb</span>
                                                                                </div>
                                                                            </div><!-- .media-group -->
                                                                        </div>
                                                                        <div class="p-3">
                                                                            <div class="media-group">
                                                                                <div class="media rounded-0">
                                                                                    <img src="./images/icon/file-type-code.svg" alt="">
                                                                                </div>
                                                                                <div class="media-text ms-1">
                                                                                    <a href="#" class="title">Weekly Finance Reports</a>
                                                                                    <span class="text smaller">10mb</span>
                                                                                </div>
                                                                            </div><!-- .media-group -->
                                                                        </div>
                                                                    </div>
                                                                </div><!-- .list-group-dotted -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nk-schedule-item">
                                                        <div class="nk-schedule-item-inner">
                                                            <div class="nk-schedule-symbol active"></div>
                                                            <div class="nk-schedule-content nk-schedule-content-no-border flex-grow-1">
                                                                <span class="smaller">5:05 PM</span>
                                                                <div class="h6">You have received a new order</div>
                                                                <div class="alert alert-info mt-2" role="alert">
                                                                    <div class="d-flex">
                                                                        <em class="icon icon-lg ni ni-file-code opacity-75"></em>
                                                                        <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                                                            <div>
                                                                                <h6 class="alert-heading mb-0">Business Template - UI/UX design</h6>
                                                                                <span class="smaller">Shared information with your team to understand and contribute to your project.</span>
                                                                            </div>
                                                                            <div class="d-block mt-1">
                                                                                <a href="#" class="btn btn-md btn-info"><em class="icon ni ni-download"></em><span>Download</span></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- .alert -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div><!-- .bio-block -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card-content -->
                                </div><!-- .card-row -->
                            </div><!-- .card -->
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection