<h4 class="bio-block-title">Recent Activity</h4>
<ul class="nk-schedule mt-4">
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