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
                <ul class="nk-nav">
                    <li class="nk-nav-item has-sub">
                        <a href="#" class="nk-nav-link nk-nav-toggle">
                            <span class="nk-nav-text">Management</span>
                        </a>
                        <ul class="nk-nav-sub nk-nav-sub-lg">
                            <li class="nk-nav-item">
                                <a href="{{route('customers.index')}}" class="nk-nav-link bg-primary-soft-hover">
                                    <div class="media-group flex-grow-1">
                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                            <em class="icon ni ni-users"></em>
                                        </div>
                                        <div class="media-text flex-grow-1">
                                            <span class="title">Customer</span>
                                            <span class="sub-text d-block">Manage Customer</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </a>
                            </li>
                            <li class="nk-nav-item">
                                <a href="{{route('users.index')}}" class="nk-nav-link bg-warning-soft-hover">
                                    <div class="media-group flex-grow-1">
                                        <div class="media media-md media-middle media-border text-bg-warning-soft-outline">
                                            <em class="icon ni ni-user"></em>
                                        </div>
                                        <div class="media-text flex-grow-1">
                                            <span class="title">Account</span>
                                            <span class="sub-text d-block">Manage Account</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </a>
                            </li>
                            <li class="nk-nav-item">
                                <a href="{{route('contracts.index')}}" class="nk-nav-link bg-secondary-soft-hover">
                                    <div class="media-group flex-grow-1">
                                        <div class="media media-md media-middle media-border text-bg-secondary-soft-outline">
                                            <em class="icon ni ni-file-docs"></em>
                                        </div>
                                        <div class="media-text flex-grow-1">
                                            <span class="title">Contract</span>
                                            <span class="sub-text d-block">Manage Contract</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </a>
                            </li>
                            <li class="nk-nav-item">
                                <a href="{{route('assets.index')}}" class="nk-nav-link bg-success-soft-hover">
                                    <div class="media-group flex-grow-1">
                                        <div class="media media-md media-middle media-border text-bg-success-soft-outline">
                                            <em class="icon ni ni-layers"></em>
                                        </div>
                                        <div class="media-text flex-grow-1">
                                            <span class="title">Asset</span>
                                            <span class="sub-text d-block">Manage Customer Asset</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
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
                    <li>
                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell"></em></button>
                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell"></em></button>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">
                            <div class="d-sm-none">
                                <div class="media media-md media-circle">
                                    <img src="./images/avatar/a.jpg" alt="" class="img-thumbnail">
                                </div>
                            </div>
                            <div class="d-none d-sm-block">
                                <div class="media media-circle">
                                    <img src="./images/avatar/a.jpg" alt="" class="img-thumbnail">
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md">
                            <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                <div class="media-group">
                                    <div class="media media-xl media-middle media-circle"><img src="./images/avatar/a.jpg" alt="" class="img-thumbnail"></div>
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
                                    <li><a href="/profile"><em class="icon ni ni-user"></em> <span>My Profile</span></a></li>
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