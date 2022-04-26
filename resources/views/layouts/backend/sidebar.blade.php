<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo.png') }}" alt="TIE-TLMAP" class="brand-image img-circle elevation-6" height="150px" style="opacity: .8">
        <span class="brand-text font-weight-light">TIE-TLMAP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('default_avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @if (Auth::check())
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    @endif
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- menu-open --}}
                <li class="nav-item has-treeview">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? __('active') : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            {{-- <i class="right fas fa-angle-left"></i> --}}
                        </p>
                    </a>

                </li>
                </li>
                <li class="nav-header">SUBJECT MANAGEMENT</li>

                <li class="nav-item has-treeview {{ request()->routeIs('suppliers.index') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-book-open"></i>
                        <p>
                            Subjects
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    All Subjects
                                </p>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="{{ route('suppliers.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Create Suppliers
                                </p>
                            </a>

                        </li>
                    </ul>
                </li>

                <li class="nav-header">BOOKS DELIVERY</li>

                <li class="nav-item has-treeview {{ request()->routeIs('receipts.index') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('receipts.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding"></i>
                        <p>
                            RECEIPT
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('receipts.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    BOOKS RECEIVED
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">SUPPLIERS REQUIREMENTS</li>
                {{-- <li class="nav-item has-treeview {{ request()->routeIs('suppliers.index') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}"> --}}
                    {{-- <li class="nav-header text-uppercase">MANAGE SUPPLIERS</li>  --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('suppliers.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-print"></i>
                            <p>
                                Suppliers
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('suppliers.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        All Suppliers
                                    </p>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a href="{{ route('suppliers.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Create Suppliers
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>


                    <li class="nav-header">SCHOOL MANAGEMENT</li>
                    {{-- <li class="nav-header">MANAGE SCHOOLS</li>  --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('schools.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('schools.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Schools
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('schools.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        All Schools
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="nav-header">SCHOOLS REQUIREMENTS</li>
                    <li class="nav-item has-treeview
                    {{ request()->routeIs('school_requirements.index') ? 'menu-open' : '' }}
                    ">
                        <a href="#" class="nav-link  {{ request()->routeIs('school_requirements.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Books Requirements
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('school_requirements.index', ['year' => request()->get('year') ? request()->get('year') : date('Y')]) }}" class="nav-link  {{ request()->routeIs('school_requirements.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Schools Data
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>

                    <li class="nav-header text-uppercase">Manage Publications</li>
                    <li class="nav-item has-treeview
                    {{
                    request()->routeIs('books.index') ||
                    request()->routeIs('books.create') ||
                    request()->routeIs('books.edit' , ":id") ||
                    request()->routeIs('publications.index') ||
                    request()->routeIs('publications.create') ||
                    request()->routeIs('publications.edit' , ":id") ||
                    request()->routeIs('authors.index') ||
                    request()->routeIs('authors.create') ||
                    request()->routeIs('authors.edit' , ":id")

                    ? 'menu-open' : '' }}
                    ">
                        <a href="#" class="nav-link
                    {{
                    request()->routeIs('books.index') ||
                    request()->routeIs('books.create') ||
                    request()->routeIs('books.edit' , ":id") ||
                    request()->routeIs('publications.index') ||
                    request()->routeIs('publications.create') ||
                    request()->routeIs('publications.edit' , ":id") ||
                    request()->routeIs('authors.index') ||
                    request()->routeIs('authors.create') ||
                    request()->routeIs('authors.edit' , ":id")
                    ? 'active' : '' }}">
                            <i class="fa fa-book nav-icon"></i>
                            <p>
                                Books & Publications
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('publications.index') }}" class="nav-link
                            {{
                                request()->routeIs('publications.index') ||
                                request()->routeIs('publications.edit' , ":id") ||
                                request()->routeIs('publications.create')

                            ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Publications
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('books.index') }}" class="nav-link
                            {{
                               request()->routeIs('books.index') ||
                               request()->routeIs('books.create') ||
                               request()->routeIs('books.edit' , ":id")
                            ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        Books
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('authors.index') }}" class="nav-link
                            {{
                               request()->routeIs('authors.index') ||
                               request()->routeIs('authors.create') ||
                               request()->routeIs('authors.edit' , ":id")
                            ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Authors
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </li>

                    <li class="nav-header text-uppercase">Manage Contracts</li>
                    <li class="nav-item has-treeview
                    {{
                        request()->routeIs('contracts.index') ||
                        request()->routeIs('contracts.show' , ':id') ||
                         request()->routeIs('publication_contract.edit' , ':id') ||
                        request()->routeIs('contracts.edit' , ':id')
                         ? 'menu-open' : '' }}
                    ">
                        <a href="#" class="nav-link  {{
                            request()->routeIs('contracts.index') ||
                            request()->routeIs('contracts.show' , ':id') ||
                            request()->routeIs('publication_contract.edit' , ':id') ||
                            request()->routeIs('contracts.edit' , ':id')
                            ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clipboard"></i>
                            <p>
                                Contracts
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('contracts.index') }}" class="nav-link
                                {{  request()->routeIs('contracts.index') ||
                                    request()->routeIs('contracts.show' , ':id') ||
                                    request()->routeIs('publication_contract.edit' , ':id') ||
                                    request()->routeIs('contracts.edit' , ':id')
                                ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        All Contracts
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>
                    <li class="nav-header text-uppercase">Manage Distributions</li>
                    <li class="nav-item has-treeview
                    {{
                        request()->routeIs('distribution_districts.index') ||
                        request()->routeIs('distribution_schools.index') ||
                        {{-- request()->routeIs('contracts.show' , ':id') || --}}
                        request()->routeIs('distribution_districts.edit' , ':id') ||
                        request()->routeIs('distribution_schools.edit' , ':id')

                         ? 'menu-open' : '' }}
                    ">
                        <a href="#" class="nav-link  {{
                           request()->routeIs('distribution_districts.index') ||
                           request()->routeIs('distribution_schools.index') ||
                           {{-- request()->routeIs('contracts.show' , ':id') || --}}
                           request()->routeIs('distribution_districts.edit' , ':id') ||
                           request()->routeIs('distribution_schools.edit' , ':id')
                            ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Distributions
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('distribution_districts.index') }}" class="nav-link
                                {{ request()->routeIs('distribution_districts.index') ||
                                   request()->routeIs('distribution_districts.edit' , ':id')
                                ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        To LGAs
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('distribution_schools.index') }}" class="nav-link
                                {{ request()->routeIs('distribution_schools.index') ||
                                   request()->routeIs('distribution_schools.edit' , ':id')
                                ? 'active' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        To Schools
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-header">USERS MANAGEMENT</li>
                    <li class="nav-item has-treeview {{ request()->routeIs('users.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        All Users
                                    </p>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Create User
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs('permissions.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-lock"></i>
                            <p>
                                Permissions
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('permissions.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        All Permissions
                                    </p>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a href="{{ route('permissions.create') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Create Permission
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs('roles.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Roles
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        All Roles
                                    </p>
                                </a>

                                <a href="{{ route('roles.create') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Create Role
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">LOCATION CHAIN</li>
                    <li class="nav-item has-treeview {{ request()->routeIs('regions.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('regions.index') ? 'active' : '' }}">
                            <i class="nav-icon far fa-map"></i>
                            <p>
                                Location
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('regions.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Regions
                                    </p>
                                </a>

                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('districts.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Districts
                                    </p>
                                </a>

                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('wards.index') }}" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Wards
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>



                    <li class="nav-header">REPORTS</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-file"></i>
                            <p>
                                Distribution Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Report
                                    </p>
                                </a>

                            </li>
                        </ul>
                    </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->

        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
