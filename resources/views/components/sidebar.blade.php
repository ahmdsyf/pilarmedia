<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Pilarmedia</span>
    </a>

    <div class="sidebar">

        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('dropdowns') }}" class="nav-link {{ Request::is('dropdowns') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-caret-down"></i>
                        <p>
                            Dropdown
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('sales') }}" class="nav-link {{ Request::is('sales') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-cart-shopping"></i>
                        <p>
                            Sales
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('sales-persons') }}" class="nav-link {{ Request::is('sales-persons') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-user"></i>
                        <p>
                            Sales Persons
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('products') }}" class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
                        <i class="nav-icon fa-brands fa-product-hunt"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>


                @can('master_sidebar')
                    <li class="nav-item {{ Request::is('user*') || Request::is('role*') || Request::is('permission*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('user_sidebar')
                                <li class="nav-item">
                                    <a href="{{ url('users') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_sidebar')
                                <li class="nav-item">
                                    <a href="{{ url('roles') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission_sidebar')
                                <li class="nav-item">
                                    <a href="{{ url('permissions') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>

    </div>

</aside>
