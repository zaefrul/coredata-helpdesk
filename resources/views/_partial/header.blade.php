@php
$Imgpath = 'images/avatar/3.png';
if(Auth::user()->profile_photo_path){
    $Imgpath = Auth::user()->profile_photo_path;
}
@endphp

    <div class="nk-header nk-header-fixed">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-header-logo ms-n1">
                <div class="nk-sidebar-toggle">
                    <button class="btn btn-sm btn-icon btn-zoom sidebar-toggle d-sm-none"><em class="icon ni ni-menu"></em></button>
                    <button class="btn btn-md btn-icon btn-zoom sidebar-toggle d-none d-sm-inline-flex"><em class="icon ni ni-menu"></em></button>
                </div>
                <div class="nk-navbar-toggle me-2">
                    <button class="btn btn-sm btn-icon btn-zoom navbar-toggle d-sm-none"><em class="icon ni ni-menu-right"></em></button>
                    <button class="btn btn-md btn-icon btn-zoom navbar-toggle d-none d-sm-inline-flex"><em class="icon ni ni-menu-right"></em></button>
                </div>
                <a href="./html/index.html" class="logo-link">
                    <div class="logo-wrap">
                        <img class="logo-img logo-light" src="./images/2.png" srcset="./images/2.png 2x" alt="">
                        <img class="logo-img logo-dark" src="./images/2.png" srcset="./images/2.png 2x" alt="">
                        <img class="logo-img logo-icon" src="./images/2.png" srcset="./images/2.png 2x" alt="">
                    </div>
                </a>
            </div>
            <nav class="nk-header-menu nk-navbar">
                
            </nav>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav ms-2">
                    <li class="dropdown">
                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="dropdown" data-bs-auto-close="outside"><em class="icon ni ni-search"></em></button>
                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="dropdown" data-bs-auto-close="outside"><em class="icon ni ni-search"></em></button>
                        <div class="dropdown-menu dropdown-menu-lg">
                            <div class="dropdown-content dropdown-content-x-lg py-1">
                                <div class="search-inline">
                                    <div class="form-control-wrap flex-grow-1">
                                        <input placeholder="Type Query" type="text" class="form-control-plaintext">
                                    </div>
                                    <em class="icon icon-sm ni ni-search"></em>
                                </div>
                            </div>
                            <div class="dropdown-divider m-0"></div>
                            <div class="dropdown-content dropdown-content-x-lg py-3">
                                <div class="dropdown-title pb-2">
                                    <h5 class="title">Recent searches</h5>
                                </div>
                                <ul class="dropdown-list gap gy-2">
                                    {{-- <li>
                                        <div class="media-group">
                                            <div class="media media-md media-middle media-circle text-bg-light"><em class="icon ni ni-clock"></em></div>
                                            <div class="media-text">
                                                <div class="lead-text">Styled Doughnut Chart</div>
                                                <span class="sub-text">1 days ago</span>
                                            </div>
                                            <div class="media-action media-action-end">
                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media-group">
                                            <div class="media media-md media-middle media-circle text-bg-light"><em class="icon ni ni-clock"></em></div>
                                            <div class="media-text">
                                                <div class="lead-text">Custom Select Input</div>
                                                <span class="sub-text">07 Aug</span>
                                            </div>
                                            <div class="media-action media-action-end">
                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media-group">
                                            <div class="media media-md media-middle media-circle text-bg-light"><img src="./images/avatar/a.jpg" alt=""></div>
                                            <div class="media-text">
                                                <div class="lead-text">Sharon Walker</div>
                                                <span class="sub-text">Admin</span>
                                            </div>
                                            <div class="media-action media-action-end">
                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                            </div>
                                        </div>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </li>
                    {{-- <li>
                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell {{ Auth::user()->unreadNotifications->count() > 0 ? 'text-danger' : '' }}"></em></button>
                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell {{ Auth::user()->unreadNotifications->count() > 0 ? 'text-danger' : '' }}"></em></button>
                    </li> --}}
                    <li>
                        <!-- For small screens -->
                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas">
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="badge bg-danger notification-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                            @else
                                <em class="icon ni ni-bell {{ Auth::user()->unreadNotifications->count() > 0 ? 'text-danger' : '' }}"></em>
                            @endif
                        </button>
                    
                        <!-- For larger screens -->
                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas">
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="badge bg-danger notification-badge" data-bs-toggle="tooltip" title="You have {{ Auth::user()->unreadNotifications->count() }} notification.">{{ Auth::user()->unreadNotifications->count() }}</span>
                            @else
                                <em class="icon ni ni-bell {{ Auth::user()->unreadNotifications->count() > 0 ? 'text-danger' : '' }}"></em>
                            @endif
                        </button>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">
                            <div class="d-sm-none">
                                <div class="media media-md media-circle">
                                    <img src="{{$Imgpath}}" alt="" class="img-thumbnail" style="width: 3rem !important; height: 3rem !important; border-radius: 50rem;">
                                </div>
                            </div>
                            <div class="d-none d-sm-block">
                                <img src="{{$Imgpath}}" alt="" class="img-thumbnail" style="width: 3rem !important; height: 3rem !important; border-radius: 50rem;">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md">
                            <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                <div class="media-group">
                                    <div class="media media-xl media-middle media-circle"><img src="{{$Imgpath}}" alt="" class="img-thumbnail" style="width: 3rem !important; height: 3rem !important; border-radius: 50rem;"></div>
                                    <div class="media-text">
                                        <div class="lead-text">{{ auth()->user()->name }}</div>
                                        <span class="sub-text">
                                            {{ ucfirst(auth()->user()->role) }}
                                        </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                <ul class="link-list">
                                    <li><a href="/users/{{Auth::user()->id}}/edit"><em class="icon ni ni-user"></em> <span>My Profile</span></a></li>
                                    {{-- <li><a href="./html/user-manage/user-cards.html"><em class="icon ni ni-contact"></em> <span>My Contacts</span></a></li>
                                    <li><a href="./html/profile-edit.html"><em class="icon ni ni-setting-alt"></em> <span>Account Settings</span></a></li> --}}
                                </ul>
                            </div>
                            <div class="dropdown-content dropdown-content-x-lg py-3">
                                <ul class="link-list">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><em class="icon ni ni-signout"></em> <span>Log Out</span></a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>