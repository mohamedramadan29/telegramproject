<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/admin/images/favicon.ico')}}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/admin/js/config.js')}}"></script>
    @toastifyCss
    @yield('css')
</head>

<body>

<!-- START Wrapper -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    <header class="topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="d-flex align-items-center">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                        <button type="button" class="button-toggle-menu me-2">
                            <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>

                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                        <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0"> @yield('title') </h4>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-1">

                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                        <button type="button" class="topbar-button" id="light-dark-mode">
                            <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>

                    <!-- Notification -->
                    <div class="dropdown topbar-item">
                        <button type="button" class="topbar-button position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <iconify-icon icon="solar:bell-bing-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge bg-danger rounded-pill">3<span class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu py-0 dropdown-lg dropdown-menu-end" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold"> الاشعارات  </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                            <small> مشاهدة الكل  </small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 280px;">
                                <!-- Item -->
                                <a href="javascript:void(0);" class="dropdown-item py-3 border-bottom">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="mb-0 fw-semibold"> محمد رمضان  </p>
                                            <p class="mb-0 text-wrap">
                                                عمل طلبية جديدة من الموقع
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="text-center py-3">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm"> مشاهدة الكل  <i class="bx bx-right-arrow-alt ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- User -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             <img class="rounded-circle" width="32" src="{{asset('assets/admin/images/users/avatar-1.jpg')}}" alt="avatar-3">
                                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header"> مرحبا {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}} ! </h6>
                            <a class="dropdown-item" href="{{url('admin/update_admin_details')}}">
                                <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span class="align-middle"> حسابي  </span>
                            </a>
                            <a class="dropdown-item" href="{{url('admin/update_admin_password')}}">
                                <i class="bx bx-message-dots text-muted fs-18 align-middle me-1"></i><span class="align-middle"> تغير كلمة المرور  </span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item text-danger" href="{{route('logout')}}">
                                <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle"> تسجيل خروج  </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
