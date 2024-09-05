@extends('front.layouts.master')
@section('title')
    الرئيسية
@endsection
@section('content')
    @if (Session::has('Success_message'))
        @php
            toastify()->success(\Illuminate\Support\Facades\Session::get('Success_message'));
        @endphp
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                toastify()->error($error);
            @endphp
        @endforeach
    @endif
    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <!-- Start here.... -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-primary rounded">
                                        <i class="bx bx-money-withdraw avatar-title fs-24 text-white"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> الرصيد </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ number_format($total_balance,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-success rounded">
                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>
                                    </div>
                                </div>
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> عدد الايداعات </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{number_format($total_deposits_count,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-danger rounded">
                                        <i class='bx bx-sort-down  avatar-title fs-24 text-white'></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> مجموع الايداعات  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{number_format($total_deposit_sum,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md text-bg-warning rounded">
                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> عدد السحوبات   </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ number_format($total_withdrawals_count,2) }} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-secondary rounded">
                                        <i class='bx bx-sort-up  avatar-title fs-24'></i>

                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0">  مجموع السحوبات   </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{number_format($total_withdrawals_sum,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-info rounded">
                                        <i class="bx bx-dollar-circle avatar-title fs-24"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0">  حجم التداول  </p>
                                    <h3 class="text-dark mt-1 mb-0">{{number_format($turnover_clear,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-dark rounded">
                                        <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0">  حصة الشريك  </p>
                                    <h3 class="text-dark mt-1 mb-0">{{number_format($vol_share,2)}} $ </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-blue rounded">
                                        <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> الاحصائيات   </p>
                                    <h3 class="text-dark mt-1 mb-0"> <a href="{{url('user/transactions')}}" style="font-size: 14px"> مشاهدة الاحصائيات  </a>  </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-dark rounded">
                                        <i class='bx bxl-discord-alt  avatar-title fs-24'></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> بوتات التيلجرام   </p>
                                    <h3 class="text-dark mt-1 mb-0"> <a href="{{url('user/boots')}}" style="font-size: 14px"> مشاهدة التفاصيل  </a>  </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{url('user/transactions')}}" class="btn btn-success"> مشاهدة الاحصائيات  </a>
            </div>

        </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection
