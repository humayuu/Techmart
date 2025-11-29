<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />

    <title>TechMart Admin Dashboard</title>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-icon fs-3">
                    <i class="bi bi-list"></i>
                </div>
                <form class="searchbar">
                    <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
                        <i class="bi bi-search"></i>
                    </div>
                    <input class="form-control" type="text" placeholder="Type here to search" />
                    <div class="position-absolute top-50 translate-middle-y search-close-icon">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </form>
                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item search-toggle-icon">
                            <a class="nav-link" href="#">
                                <div class="">
                                    <i class="bi bi-search"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="projects">
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="row row-cols-3 gx-2">
                                    <div class="col">
                                        <a href="ecommerce-orders.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-purple">
                                                    <i class="bi bi-basket2-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Orders</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-info">
                                                    <i class="bi bi-people-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Users</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="ecommerce-products-grid.html">
                                            <div class="apps p-2 radius-10 text-center">
                                                <div class="apps-icon-box mb-1 text-white bg-gradient-success">
                                                    <i class="bi bi-trophy-fill"></i>
                                                </div>
                                                <p class="mb-0 apps-name">Products</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="notifications">
                                    <span class="notify-badge">8</span>
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2 border-bottom m-2">
                                    <h5 class="h5 mb-0">Notifications</h5>
                                </div>
                                <div class="header-notifications-list p-2">
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="notification-box bg-light-primary text-primary">
                                                <i class="bi bi-basket2-fill"></i>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-0 dropdown-msg-user">
                                                    New Orders
                                                    <span class="msg-time float-end text-secondary">1 m</span>
                                                </h6>
                                                <small
                                                    class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">You
                                                    have recived new orders</small>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="p-2">
                                    </div>
                                </div>
                        </li>
                    </ul>
                </div>
                <div class="dropdown dropdown-user-setting">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-3">
                            <img src="{{ asset('assets/images/avatars/avatar-1.png') }}" class="user-img"
                                alt="" />
                            <div class="d-none d-sm-block">
                                <p class="user-name mb-0">Humayun</p>
                                <small class="mb-0 dropdown-user-designation">Admin</small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="pages-user-profile.html">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-gear-fill"></i></div>
                                    <div class="ms-3"><span>Change Password</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-lock-fill"></i></div>
                                    <div class="ms-3"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                </div>
                <div>
                    <h4 class="logo-text fs-2 m-4">TechMart</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class="bi bi-list"></i></div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="javascript:;">
                        <div class="parent-icon"><i class="bi bi-house-fill"></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li class="menu-label">Main Menu</li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <div class="menu-title">Brand Management</div>
                    </a>
                    <ul>
                        <li>
                            <a href="#"><i class="bi bi-circle"></i>All Brands</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end navigation-->
        </aside>
        <!--end sidebar -->
        @yield('main')
        <!--start footer-->
        <footer class="footer">
            <div class="footer-text">Copyright © 2026. All right reserved.</div>
        </footer>
        <!--end footer-->


        <!-- Bootstrap bundle JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!--plugins-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/pace.min.js') }}"></script>
        <!--app-->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/js/index.js') }}"></script>
</body>

</html>
