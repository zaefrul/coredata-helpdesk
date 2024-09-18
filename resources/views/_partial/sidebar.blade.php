<div class="nk-sidebar nk-sidebar-fixed is-theme" id="sidebar">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/" class="logo-link">
                <div class="logo-wrap">
                    <img class="logo-img logo-light" src="./images/2.png" srcset="./images/2.png" alt="">
                    <img class="logo-img logo-dark" src="./images/2.png" srcset="./images/2.png" alt="">
                    <img class="logo-img logo-icon" src="./images/coredata-logo-only.png" srcset="./images/coredata-logo-only.png" alt="">
                </div>
            </a>
            <div class="nk-compact-toggle me-n1">
                <button class="btn btn-md btn-icon text-light btn-no-hover compact-toggle">
                    <em class="icon off ni ni-chevrons-left"></em>
                    <em class="icon on ni ni-chevrons-right"></em>
                </button>
            </div>
            <div class="nk-sidebar-toggle me-n1">
                <button class="btn btn-md btn-icon text-light btn-no-hover sidebar-toggle">
                    <em class="icon ni ni-arrow-left"></em>
                </button>
            </div>
        </div>
        <!-- end nk-sidebar-brand -->
    </div>
    <!-- end nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        @php
                            if(Auth::user()->role != 'user'){
                                $dashboard = route('dashboard');
                            } else {
                                $dashboard = route('user.dashboard');
                            }
                        @endphp
                        <a href="{{$dashboard}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chart-up"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    @if (Auth::user()->role != 'user')
                        @php
                            $isAadmin = Auth::user()->role == 'admin';
                        @endphp
                        {{-- customer --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Customer Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('customers.index') ? 'active' : ''}}">
                                    <a href="/customers" class="nk-menu-link">
                                        <span class="nk-menu-text">Customer List</span>
                                    </a>
                                </li>
                                @if($isAadmin)
                                <li class="nk-menu-item {{request()->routeIs('customers.create') ? 'active' : ''}}">
                                    <a href="/customers/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Customer</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        {{-- end customer --}}
                        {{-- user management --}}
                        @if($isAadmin)
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                <span class="nk-menu-text">Account Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('users.index') ? 'active' : ''}}">
                                    <a href="/users" class="nk-menu-link">
                                        <span class="nk-menu-text">Account List</span>
                                    </a>
                                </li>
                                @if($isAadmin)
                                <li class="nk-menu-item {{request()->routeIs('users.create') ? 'active' : ''}}">
                                    <a href="/users/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Account</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        {{-- end user management --}}
                        {{-- contract management --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                <span class="nk-menu-text">Project Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('contracts.index') ? 'active' : ''}}">
                                    <a href="/contracts" class="nk-menu-link">
                                        <span class="nk-menu-text">Project List</span>
                                    </a>
                                </li>
                                @if($isAadmin)
                                <li class="nk-menu-item {{request()->routeIs('contracts.create') ? 'active' : ''}}">
                                    <a href="/contracts/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Project</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        {{-- end contract management --}}
                        {{-- asset --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span>
                                <span class="nk-menu-text">Asset Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('assets.index') ? 'active' : ''}}">
                                    <a href="/resources" class="nk-menu-link">
                                        <span class="nk-menu-text">Asset List</span>
                                    </a>
                                </li>
                                @if($isAadmin)
                                <li class="nk-menu-item {{request()->routeIs('assets.create') ? 'active' : ''}}">
                                    <a href="/resources/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Asset</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        {{-- end asset --}}
                        {{-- inventory --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-box"></em></span>
                                <span class="nk-menu-text">Inventory Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('inventories.index') ? 'active' : ''}}">
                                    <a href="/inventories" class="nk-menu-link">
                                        <span class="nk-menu-text">Inventory List</span>
                                    </a>
                                </li>
                                @if($isAadmin)
                                <li class="nk-menu-item {{request()->routeIs('inventories.create') ? 'active' : ''}}">
                                    <a href="/inventories/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Inventory</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        {{-- end inventory --}}
                        {{-- service --}}
                        {{-- incident --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-alert-circle"></em></span>
                                <span class="nk-menu-text">Incident Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('incidents.index') ? 'active' : ''}}">
                                    <a href="/incidents" class="nk-menu-link">
                                        <span class="nk-menu-text">Incident List</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item {{request()->routeIs('incidents.create') ? 'active' : ''}}">
                                    <a href="/incidents/create" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Incident</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- end incident --}}

                        @if (Auth::user()->role == 'admin')
                        {{-- admin --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Admin Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('admins.index') ? 'active' : ''}}">
                                    <a href="/admin" class="nk-menu-link">
                                        <span class="nk-menu-text">Control Panel</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- end admin --}}
                        @endif
                    @else
                        {{-- incident --}}
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-alert-circle"></em></span>
                                <span class="nk-menu-text">Incident Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{request()->routeIs('incidents.index') ? 'active' : ''}}">
                                    <a href="{{route('user.incidents.index')}}" class="nk-menu-link">
                                        <span class="nk-menu-text">Incident List</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item {{request()->routeIs('incidents.create') ? 'active' : ''}}">
                                    <a href="{{route('user.incidents.create')}}" class="nk-menu-link">
                                        <span class="nk-menu-text">Add New Incident</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- end incident --}}
                    @endif
                </ul><!-- .nk-menu -->
                
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
