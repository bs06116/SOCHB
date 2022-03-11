<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}" data-toggle="tooltip"
                data-original-title="{{ setting('company_name') }}">
                {{-- @if (setting('company_logo'))
                    <img alt="{{ setting('company_name') }}" height="45" class="navbar-brand-img"
                        src="{{ asset(setting('company_logo')) }}">
                @else
                    {{ substr(setting('company_name'), 0, 15) }}...
                @endif --}}
                <img src="{{ asset('assets/img/logo.png') }}">
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ (request()->is('home*')) ? 'active' : '' }}" href="{{route('home')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li> --}}
                    {{-- @can('update-settings')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('settings*')) ? 'active' : '' }}" href="{{route('settings.index')}}">
                                <i class="ni ni-settings-gear-65 text-primary"></i>
                                <span class="nav-link-text">Manage Settings</span>
                            </a>
                        </li>
                    @endcan --}}

                    {{-- @canany(['view-category', 'create-category'])
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('category*')) ? 'active' : '' }}" href="#navbar-category"  data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-category">
                                <i class="fas text-primary fa-list-alt"></i>
                                <span class="nav-link-text">Manage Category</span>
                            </a>
                            <div class="collapse" id="navbar-category">
                                <ul class="nav nav-sm flex-column">
                                 @can('view-category')
                                    <li class="nav-item">
                                        <a href="{{route('category.index')}}" class="nav-link"><span class="sidenav-mini-icon">D </span><span class="sidenav-normal">All Categories</span></a>
                                    </li>
                                    @endcan
                                    @can('create-category')
                                    <li class="nav-item">
                                        <a href="{{route('category.create')}}" class="nav-link"><span class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New Category</span></a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>

                    @endcan --}}
                    {{-- @canany(['view-post', 'create-post'])

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('post*')) ? 'active' : '' }}" href="#navbar-post"  data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-post">
                                <i class="fas text-primary fa-tasks"></i>
                                <span class="nav-link-text">Manage Posts</span>
                            </a>
                            <div class="collapse" id="navbar-post">
                                <ul class="nav nav-sm flex-column">
                                 @can('view-post')
                                    <li class="nav-item">
                                        <a href="{{route('post.index')}}" class="nav-link"><span class="sidenav-mini-icon">D </span><span class="sidenav-normal">All Posts</span></a>
                                    </li>
                                    @endcan
                                    @can('create-post')
                                    <li class="nav-item">
                                        <a href="{{route('post.create')}}" class="nav-link"><span class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New Post</span></a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan --}}


                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-users"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                {{-- <i class="fas text-primary fa-tasks"></i> --}}
                                <i class="fa text-primary fa-th"></i>
                                <span class="nav-link-text">System</span>
                            </a>
                            <?php if(request()->is('admin/users*') || request()->is('admin/permissions*') ||  request()->is('admin/roles*')){
                                $active = 'show';}else{$active = '';} ?>

                            <div class="collapse {{$active}}" id="navbar-users">
                                <ul class="nav nav-sm flex-column">
                                    @can('view-user')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('users.index') }}">
                                                <i class="fa fa-user text-primary"></i>
                                            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                                <i class="fas fa-lock-open text-primary"></i>
                                                <span class="nav-link-text">Users</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @canany(['view-permission', 'create-permission'])
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}"
                                                href="{{ route('permissions.index') }}">
                                                <i class="fas fa-thumbs-up text-primary"></i>
                                                <span class="nav-link-text">Manage Permissions</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @canany(['view-role', 'create-role'])
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}"
                                                href="{{ route('roles.index') }}">
                                                <i class="fas fa-users text-primary"></i>
                                                <span class="nav-link-text">Manage Roles</span>
                                            </a>
                                        </li>
                                    @endcan
                                    {{-- @can('create-user')
                                    <li class="nav-item">
                                        <a href="{{route('users.create')}}" class="nav-link"><span class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New User</span></a>
                                    </li>
                                    @endcan --}}
                                </ul>
                            </div>
                        </li>



                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-basic"
                            data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                            <i class="fa text-primary fa-cog"></i>
                            <span class="nav-link-text">Basic Configurations</span>
                        </a>
                        <?php if(request()->is('admin/companies*') || request()->is('admin/locations*') ||  request()->is('admin/vendors*') ||  request()->is('admin/siem*')){
                            $active = 'show';}else{$active = '';} ?>
                        <div class="collapse {{$active}}" id="navbar-basic">
                            <ul class="nav nav-sm flex-column">
                                @canany(['manage-company'])

                                    <li class="nav-item">
                                        <a href="{{ route('companies.index') }}" class="nav-link">
                                            <i class="fa fa-building text-primary"></i>
                                            <span class="sidenav-normal">Company</span></a>
                                    </li>
                                @endcan
                                @canany(['manage-location'])
                                    <li class="nav-item">
                                        <a href="{{ route('locations.index') }}" class="nav-link">
                                            <i class="fa fa-map-marker text-primary"></i>
                                            <span class="sidenav-normal">Location</span></a>
                                    </li>
                                @endcan

                                @canany(['manage-vendor'])
                                <li class="nav-item">
                                    <a href="{{ route('vendors.index') }}" class="nav-link">
                                        <i class="fa fa-sitemap text-primary"></i>
                                        <span class="sidenav-normal">Vendor</span></a>
                                </li>
                            @endcan
                            @canany(['manage-sem'])
                            <li class="nav-item">
                                <a href="{{ route('siem.index') }}" class="nav-link">
                                    <i class="fa fa-vote-yea text-primary"></i>
                                    <span class="sidenav-normal">Manage SIEM</span></a>
                            </li>
                        @endcan

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-assets"
                            data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-assets">
                            <i class="fa text-primary fa-cubes"></i>
                            <span class="nav-link-text">Assets Management</span>
                        </a>
                        <?php if(request()->is('admin/assetcategorydetail*') || request()->is('admin/applicationresourcecategory*') ||  request()->is('admin/assetapplication*') ||  request()->is('admin/assetmanagement*')){
                            $active = 'show';}else{$active = '';} ?>
                        <div class="collapse {{$active}}" id="navbar-assets">
                            <ul class="nav nav-sm flex-column">
                                @canany(['manage-asset-category-details'])
                                    <li class="nav-item">
                                        <a href="{{ route('assetcategorydetail.index') }}" class="nav-link">
                                            <i class="fa text-primary fa-list-ul"></i>
                                            <span class="sidenav-normal">Assets Category Details</span></a>
                                    </li>
                                @endcan
                                @canany(['manage-application-resource-category'])
                                    <li class="nav-item">
                                        <a href="{{ route('applicationresourcecategory.index') }}"
                                            class="nav-link">
                                            <i class="fa text-primary fa-window-restore"></i>
                                            <span
                                                class="sidenav-normal">Application Resource Category
                                            </span></a>
                                    </li>
                                @endcan
                                @canany(['manage-asset-application'])
                                    <li class="nav-item">
                                        <a href="{{ route('assetapplication.index') }}" class="nav-link">

                                            <i class="fa text-primary fa-keyboard"></i>

                                            <span class="sidenav-normal">Asset
                                                Application
                                            </span></a>
                                    </li>
                                @endcan
                                @canany(['manage-asset-management'])
                                    <li class="nav-item">
                                        <a href="{{ route('assetmanagement.index') }}" class="nav-link">
                                            <i class="fa text-primary fa-list-alt"></i>

                                            <span class="sidenav-normal">Asset
                                                Management
                                            </span></a>
                                    </li>
                                @endcan
                                {{-- <li class="nav-item">
                                    <a href="{{route('siem.index')}}" class="nav-link"><span class="sidenav-mini-icon"></span><span class="sidenav-normal">SEM</span></a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>

                    {{-- @canany(['media'])
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('media*')) ? 'active' : '' }}" href="{{route('media.index')}}">
                                <i class="fas fa-images text-primary"></i>
                                <span class="nav-link-text">Manage Media</span>
                            </a>
                        </li>
                    @endcan --}}
                    {{-- @canany(['view-activity-log'])
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('activity-log*')) ? 'active' : '' }}" href="{{route('activity-log.index')}}">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Activity Log</span>
                            </a>
                        </li>
                    @endcan --}}
                    <li class="nav-item">
                        <hr class="my-3">
                    </li>
                    {{-- <li class="nav-item">
                            <a class="nav-link active active-pro" href="{{route('components')}}">
                                <i class="ni ni-send text-primary"></i>
                                <span class="nav-link-text">Components</span>
                            </a>
                        </li> --}}
                </ul>
            </div>
        </div>
    </div>
</nav>
