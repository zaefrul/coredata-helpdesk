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