<div class="nk-sidebar nk-sidebar-fixed is-theme" id="sidebar">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/" class="logo-link">
                <div class="logo-wrap">
                    <img class="logo-img logo-light" src="/images/logo.png" srcset="./images/logo2x.png 2x" alt="">
                    <img class="logo-img logo-dark" src="/images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="">
                    <img class="logo-img logo-icon" src="/images/logo-icon.png" srcset="./images/logo-icon2x.png 2x" alt="">
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
                        <a href="/dashboard" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chart-up"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
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
                            <li class="nk-menu-item {{request()->routeIs('customers.create') ? 'active' : ''}}">
                                <a href="/customers/create" class="nk-menu-link">
                                    <span class="nk-menu-text">Add New Customer</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- end customer --}}
                    {{-- project --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Project Management</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{request()->routeIs('projects.index') ? 'active' : ''}}">
                                <a href="/projects" class="nk-menu-link">
                                    <span class="nk-menu-text">Project List</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{request()->routeIs('projects.create') ? 'active' : ''}}">
                                <a href="/projects/create" class="nk-menu-link">
                                    <span class="nk-menu-text">Add New Project</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- end project --}}
                    {{-- contract management --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                            <span class="nk-menu-text">Contract Management</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{request()->routeIs('contracts.index') ? 'active' : ''}}">
                                <a href="/contracts" class="nk-menu-link">
                                    <span class="nk-menu-text">Contract List</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{request()->routeIs('contracts.create') ? 'active' : ''}}">
                                <a href="/contracts/create" class="nk-menu-link">
                                    <span class="nk-menu-text">Add New Contract</span>
                                </a>
                            </li>
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
                                <a href="/assets" class="nk-menu-link">
                                    <span class="nk-menu-text">Asset List</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{request()->routeIs('assets.create') ? 'active' : ''}}">
                                <a href="/assets/create" class="nk-menu-link">
                                    <span class="nk-menu-text">Add New Asset</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- end asset --}}
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
