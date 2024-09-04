<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template"/>
    <meta name="author" content="Techzaa"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo-letter.svg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/front/css/vendor.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/front/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/front/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/front/js/config.js')}}"></script>
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
                    @php
                        $last_balance = 0;
                        $last_vol = 0;
                                                $user = \Illuminate\Support\Facades\Auth::user();
                                                $tradersIds = \App\Models\front\TraderId::where('user_id', \Illuminate\Support\Facades\Auth::id())->pluck('trader_id')->toArray();
                                                /////// Get All The Transactions Where Trader_id == transaction Trader Id
                                                ///
                                                $transactions = \App\Models\admin\Transaction::whereIn('trader-id', $tradersIds)
                                                    ->orderBy('id', 'DESC')
                                                    ->get();
                                                /////////// حصة الشريك
                                                /// volshare = userbalance
                                                $vol_share = $transactions->sum('vol-share');
                                                ////// WithDrawSum Compeleted
                                                $withdrawSumCompeleted = \App\Models\admin\WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');
                                                $last_vol_share = $vol_share - $withdrawSumCompeleted;

                                                  $issaturday = Carbon\Carbon::now()->isSaturday();
                                                     if(!$issaturday){
                                                         $last_vol = $last_vol_share;
                                                     }else{
                                                       $last_balance = $last_vol_share;
                                                     }
                    @endphp

                            <!-- Menu Toggle Button -->
                    <div class="topbar-item">
{{--                        <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0"> @yield('title') </h4>--}}
                        <div class="section_balance" style="margin-top: 30px">
                            <h5><strong> {{number_format($last_balance,2)}} $ </strong> <a href="{{url('user/withdraws')}}"
                                                                                           class="btn btn-primary btn-sm">
                                    سحب <i
                                            class="bx bx-arrow-from-right"></i> </a></h5>
                            <p> الارباح :: <strong> {{number_format($last_vol,2)}} $ </strong></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                        <button type="button" class="topbar-button" id="light-dark-mode">
                            <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>

                    <!-- User -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             <i class='bx bxs-down-arrow'></i> {{\Illuminate\Support\Facades\Auth::user()->email}}
                                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header"> مرحبا {{\Illuminate\Support\Facades\Auth::user()->name}}
                                ! </h6>
                            <a class="dropdown-item" href="{{url('user/update_user_details')}}">
                                <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span
                                        class="align-middle"> حسابي  </span>
                            </a>
                            <a class="dropdown-item" href="{{url('user/update_user_password')}}">
                                <i class="bx bx-message-dots text-muted fs-18 align-middle me-1"></i><span
                                        class="align-middle"> تغير كلمة المرور  </span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item text-danger" href="{{route('user_logout')}}">
                                <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle"> تسجيل خروج  </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
