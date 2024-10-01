<h4 class="bio-block-title">Recent Activity</h4>
<ul class="nk-schedule mt-4">
    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
        @if($incident && $incident->status === 'resolved')
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        {{-- <span class="smaller">{{$activityLog->created_at->diffForHumans()}} - <strong>{{$activityLog->user->name}}</strong></span> --}}
                        <div class="h6 text-warning">
                            Preventive Maintenance has been completed for this incident. Please verify the resolution.
                        </div>
                        <div class="alert alert-success mt-2" role="alert">
                            <div class="d-flex">
                                <em class="icon icon-lg ni ni-check-round"></em>
                                <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                    <div>
                                        <span class="smaller">Please provide your confirmation about this activity.</span>
                                        <a class="btn btn-sm btn-success" href="{{route('incident.verify', $incident->id)}}">Verify</a>
                                        <a class="btn btn-sm btn-danger" href="{{route('incident.reopen', $incident->id)}}">Open Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endif
    @endif
    @foreach($activityLogs as $activityLog)
        <li class="nk-schedule-item">
            <div class="nk-schedule-item-inner">
                <div class="nk-schedule-symbol active"></div>
                <div class="nk-schedule-content">
                    <span class="smaller">{{$activityLog->created_at->diffForHumans()}} - <strong>{{$activityLog->user->name}}</strong></span>
                    <div class="h6">
                        {!! $activityLog->description !!}
                    </div>
                    @if($activityLog->comment)
                        <div class="alert alert-info mt-2" role="alert">
                            <div class="d-flex">
                                <em class="icon icon-lg ni ni-user-round"></em>
                                <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                    <div>
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