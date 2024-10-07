<div class="offcanvas offcanvas-end offcanvas-size-lg" id="notificationOffcanvas">
    <div class="offcanvas-header border-bottom border-light">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Recent Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" data-simplebar>
        {{-- link to clear all notification --}}
        @if(auth()->user()->unreadNotifications->isEmpty())
            <div class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        <span class="smaller">No new notification</span>
                    </div>
                </div>
            </div>
        @else
        <div class="nk-schedule mb-4" style="text-align: right">
            <a href="{{ route('users.read-notifications') }}" class="link-info fs-6">Clear All</a>
        </div>
        <ul class="nk-schedule">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <li class="nk-schedule-item">
                    <div class="nk-schedule-item-inner">
                        <div class="nk-schedule-symbol active"></div>
                        <div class="nk-schedule-content">
                            <span class="smaller">{{$notification->created_at->diffForHumans()}}</span>
                            <div class="alert alert-success mt-2" role="alert">
                                <div class="d-flex">
                                    <em class="icon icon-lg ni ni-ticket"></em>
                                    <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                        <div>
                                            <span class="smaller">{{$notification->data['message']}}</span>
                                            <a class="link-primary fs-6" href="/incidents/{{ $notification->data['incident_number'] }}/show">{{ $notification->data['incident_number'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
