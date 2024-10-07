@extends('admin.layouts.master')
@section('title') الرئيسية  @endsection
@section('content')
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
                                    <i class="bx bx-user avatar-title fs-24 text-white"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0"> العملاء  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  \App\Models\front\User::all()->count(); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/users')}}" type="button" class="btn btn-sm btn-primary">
                                 مشاهدة التفاصيل
                                <i class="ti ti-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-money-withdraw avatar-title fs-32 text-primary"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0">  الرصيد  </p>
                                <h3 class="text-dark mt-1 mb-0"> 100 $ </h3>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div> <!-- end card body -->
                    <div class="card-footer py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{url('admin/transactions')}}" class="text-reset fw-semibold fs-12"> مشاهدة التفاصيل  </a>
                        </div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
            <div class="col-md-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bx-objects-vertical-bottom avatar-title fs-32 text-primary"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0">  المعاملات  </p>
                                <h3 class="text-dark mt-1 mb-0"> 80 </h3>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div> <!-- end card body -->
                    <div class="card-footer py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{url('admin/transactions')}}" class="text-reset fw-semibold fs-12"> مشاهدة التفاصيل  </a>
                        </div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-md-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-soft-primary rounded">
                                    <i class="bx bxs-message-rounded-dots avatar-title fs-24 text-primary"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0 text-truncate"> الدعم الفني </p>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div> <!-- end card body -->
                    <div class="card-footer py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="#!" class="text-reset fw-semibold fs-12"> رسائل الدعم  </a>
                        </div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-md-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-soft-primary rounded">
                                    <iconify-icon icon="solar:ufo-2-bold-duotone" class="avatar-title fs-24 text-primary"></iconify-icon>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0 text-truncate"> بوتات التيلجرام  </p>
                                <h3 class="text-dark mt-1 mb-0">3</h3>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div> <!-- end card body -->
                    <div class="card-footer py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="#!" class="text-reset fw-semibold fs-12"> مشاهدة التفاصيل  </a>
                        </div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1"> احدث المعاملات  </h4>
                        <a href="{{url('admin/transactions')}}" class="btn btn-sm btn-primary"> جميع المعاملات  <i
                                class="ti ti-eye"></i></a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="table-search" class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th style="width: 20px;">
                                    </th>
                                    <th> المعرف   </th>
                                    <th>  الدولة  </th>
                                    <th>  الرمز التعريفي  </th>
                                    <th>  الرصيد </th>
                                    <th> عدد مرات الايداع  </th>
                                    <th> مجموع الايداع   </th>
                                    <th> مرات السحب </th>
                                    <th>  المجموع  </th>
                                    <th> التاريخ   </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php

                                    $i = 1;
                                @endphp
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            {{$i++}}
                                        </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                        <td> {{$transaction['trader']}} </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

        </div> <!-- end row -->

    </div>

</div>
<!-- ==================================================== -->
<!-- End Page Content -->
<!-- ==================================================== -->
@endsection
