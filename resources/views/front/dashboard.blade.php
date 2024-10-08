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
                <div class="col-lg-3 col-12">
                    <div class="new_balance">
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
                                     $last_vol = $last_main_price;
                                 }else{
                                   $last_balance =  $last_main_price;
                                 }
                        @endphp
                        <div class="current_balance">
                            <h6> رصيدك </h6>
                            <p> {{number_format($last_main_price,2)}} دولار </p>
                            <a href="{{url('user/withdraws')}}" class="btn btn-primary btn-sm"> انتقل الي السحب <i
                                        class="bx bx-arrow-from-right"></i> </a>
                        </div>
                        <div class="all_balance">
                            <p> مجموع السحوبات  </p>
                            <h5> {{number_format($withdrawSumCompeleted,2)}} دولار </h5>
                        </div>
                    </div>

                    <style>
                        .new_balance {
                            background-color: #1E1E2D;
                            border-radius: 10px;
                            padding: 10px;
                            color: #fff;
                            margin-bottom: 10px;
                            padding-right: 20px;
                        }

                        .new_balance .current_balance {

                        }

                        .new_balance .current_balance h6 {
                            color: #e3e3e3;
                            font-size: 22px;
                        }

                        .new_balance .current_balance p {
                            font-weight: bold;
                            font-size: 30px;
                            margin: 0;
                        }

                        .new_balance .current_balance a {
                            background-color: #0BB783;
                            border-color: #0BB783;
                            font-size: 17px;
                        }

                        .new_balance .all_balance {
                            margin-top: 15px;
                        }

                        .new_balance .all_balance p {
                            color: #b1b1b1;
                            font-size: 16px;
                        }

                        .new_balance .all_balance h5 {
                            color: #fff;
                            font-size: 19px;
                        }
                    </style>

                </div>
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
                                    <p class="text-muted mb-0"> الربح  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ number_format($allbalance,2)}} $ </h3>

                                </div>
                                <button style="margin-top: 10px" type="button" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#balance_details">
                                    تفاصيل الرصد
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md bg-success rounded">--}}
                {{--                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> عدد الايداعات </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0"> {{$total_deposits_count}}  </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
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
                                    <p class="text-muted mb-0"> مستوي الحساب </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{$current_level['name']}}  </h3>
                                </div>
                                <a style="margin-top: 10px" href="{{url('user/levels')}}" type="button" class="btn btn-sm btn-success">
                                    تفاصيل المستوي
                                    <i class="ti ti-eye"></i>
                                </a>
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
                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>
                                    </div>
                                </div>
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0">مركز وكالات كيوتيكس </p>

                                </div>
                                <a style="margin-top: 10px" href="{{url('user/referrals')}}" type="button"
                                   class="btn btn-sm btn-danger">
                                    مشاهدة التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-warning rounded">
                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>
                                    </div>
                                </div>
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> رابط المشاركه لمنصه Quotex </p>
                                    <p> قم إنشاء حساب  Qoutex  خاص بك  عبر رابط الإحاله لزياده ربحك . </p>
                                </div>
                                <a style="margin-top: 10px" href="{{url('user/link')}}" type="button"
                                   class="btn btn-sm btn-warning">
                                    مشاهدة التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md bg-danger rounded">--}}
                {{--                                        <i class='bx bx-sort-down  avatar-title fs-24 text-white'></i>--}}
                {{--                                    </div>--}}
                {{--                                </div> <!-- end col -->--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> مجموع الايداعات </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0"> {{number_format($total_deposit_sum,2)}} $ </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md text-bg-warning rounded">--}}
                {{--                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>--}}
                {{--                                    </div>--}}
                {{--                                </div> <!-- end col -->--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> عدد السحوبات </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0"> {{ $total_withdrawals_count }} </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md bg-secondary rounded">--}}
                {{--                                        <i class='bx bx-sort-up  avatar-title fs-24'></i>--}}

                {{--                                    </div>--}}
                {{--                                </div> <!-- end col -->--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> مجموع السحوبات </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0"> {{number_format($total_withdrawals_sum,2)}} $ </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md bg-info rounded">--}}
                {{--                                        <i class="bx bx-dollar-circle avatar-title fs-24"></i>--}}
                {{--                                    </div>--}}
                {{--                                </div> <!-- end col -->--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> حجم التداول </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0">{{number_format($turnover_clear,2)}} $ </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="col-md-6 col-xl-3">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-4">--}}
                {{--                                    <div class="avatar-md bg-dark rounded">--}}
                {{--                                        <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>--}}
                {{--                                    </div>--}}
                {{--                                </div> <!-- end col -->--}}
                {{--                                <div class="col-8 text-start">--}}
                {{--                                    <p class="text-muted mb-0"> حصة الشريك </p>--}}
                {{--                                    <h3 class="text-dark mt-1 mb-0">{{number_format($vol_share,2)}} $ </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
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
                                    <p class="text-muted mb-0"> الاحصائيات </p>
                                    {{--                                    <h3 class="text-dark mt-1 mb-0"><a href="{{url('user/transactions')}}"--}}
                                    {{--                                                                       style="font-size: 14px"> مشاهدة الاحصائيات </a>--}}
                                    {{--                                    </h3>--}}
                                </div>
                                <a style="margin-top: 10px" href="{{url('user/transactions')}}" type="button"
                                   class="btn btn-sm btn-blue">
                                    مشاهدة الاحصائيات
                                    <i class="ti ti-eye"></i>
                                </a>
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
                                    <p class="text-muted mb-0"> بوتات التيلجرام </p>
                                    {{--                                    <h3 class="text-dark mt-1 mb-0"><a href="{{url('user/boots')}}"--}}
                                    {{--                                                                       style="font-size: 14px"> مشاهدة التفاصيل </a>--}}
                                    {{--                                    </h3>--}}
                                </div>
                                <a style="margin-top: 10px" href="{{url('user/boots')}}" type="button"
                                   class="btn btn-sm btn-dark">
                                    مشاهدة التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{url('user/transactions')}}" class="btn btn-success"> مشاهدة الاحصائيات </a>
            </div>

        </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

    <div class="modal fade" id="balance_details" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تفاصيل الرصد الخاصة بك </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> مجموع الارباح </label>
                        <input disabled readonly type="text" name="name" class="form-control" placeholder="اسم البوت  "
                               value="{{$profit_without_bouns}} $">
                    </div>
                    <div class="mb-3">
                        <label for=""> هدية المستوي </label>
                        <input disabled readonly type="text" name="username" class="form-control"
                               placeholder="الاسم التعريفي"
                               value="{{$level_bouns}} $">
                    </div>
                    <div class="mb-3">
                        <label for=""> مجموع ارباح الاحالات </label>
                        <input disabled readonly type="text" name="link" class="form-control" placeholder="الرابط"
                               value="{{$user_earning}} $">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> اغلاق</button>
                </div>
            </div>
        </div>
    </div>

@endsection

