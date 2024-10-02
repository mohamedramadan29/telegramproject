@extends('front.layouts.master')
@section('title')
    المعاملات المالية
@endsection
@section('css')

    {{--    <!-- DataTables CSS -->--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
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
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="progress" role="progressbar" aria-label="Warning example striped"
                                     aria-valuenow="{{$current_progress}}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-striped text-bg-warning" style="width: {{$current_progress}}%">{{$current_progress}}%</div>
                                </div>


                                <div class="count_level d-flex">
                                    <div class="info_count">
                                        <h6> مستوي الحساب </h6>
                                        <p> {{$current_level['name']}} </p>
                                    </div>
                                    <div class="info_count">
                                        <h6> نسبة الربح </h6>
                                        <p> {{ number_format($current_level['percent_volshare'],2)}} ٪ </p>
                                    </div>
                                    <div class="info_count">
                                        <h6> هدايا الحساب </h6>
                                        <p> {{ number_format($current_level['Bonus'],2)}} $ </p>
                                    </div>
                                    <div class="info_count">
                                        <h6> مجموع الارباح </h6>
                                        <p> {{ number_format($profit,2)}} $ </p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <style>
                                        .progress, .progress-stacked{
                                            height: 1.4rem !important;
                                            margin-bottom: 15px;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }
                                        .count_level{
                                            align-items: center;
                                            flex-wrap: wrap;
                                            justify-content: center;
                                            padding-bottom: 10px;
                                        }
                                        .info_count{
                                            margin: 10px;
                                            background: #f1eded;
                                            padding: 10px;
                                            border-radius: 9px;
                                            text-align: center;
                                            border: 1px solid #ccc;
                                            min-width: 170px;
                                        }
                                        @media(max-width: 991px){
                                            .info_count{
                                                min-width: 110px
                                            }
                                        }
                                        .info_count h6{
                                            padding-top: 10px;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }
                                        .info_count p{
                                            font-weight: bold;
                                            font-size: 19px;
                                            color: #E6612A;
                                        }
                                    </style>
                                    <div class="row">
                                        <div class="col-12">
                                            <form method="post" action="{{url('user/trader-id/add')}}">
                                                @csrf
                                                <div class="d-flex">
                                                    <div class="mb-3" style="width:80%">
                                                        <input type="number" class="form-control" value=""
                                                               name="trader_id" placeholder="ادخل ال Id">
                                                    </div>
                                                    <div class="mb-3" style="width:20%">
                                                        <button type="submit" class="btn btn-primary"> اضافة
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .my_balance {
                                    }

                                    .my_balance .info {
                                        background-color: #1E1E2D;
                                        color: #fff;
                                        padding: 15px;
                                        border-radius: 10px;
                                        text-align: center;
                                    }

                                    .my_balance .info h5 {
                                        color: #fff;
                                        font-size: 25px;
                                        margin-bottom: 15px;
                                    }

                                    .my_balance .info p {
                                        font-size: 20px;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                            <h4 class="card-title flex-grow-1"> المعاملات المالية </h4>
                        </div>


                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <tfoot>
                                    <tr>
                                        <td style="color: #FE6C2F"> <strong> {{$transactions->count()}}  </strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$total_balance}}  $</strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$total_deposits_count}}  </strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$total_deposit_sum}} $ </strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$total_withdrawals_count}}  </strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$total_withdrawals_sum}} $  </strong></td>
                                        <td style="color: #FE6C2F"><strong> {{$turnover_clear}} $ </strong></td>
                                    </tr>
                                    </tfoot>
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th> المعرف (id)</th>
                                        <th> الرصيد</th>
                                        <th> عدد الايداعات</th>
                                        <th> مجموع الايداعات</th>
                                        <th> عدد السحوبات</th>
                                        <th> مجموع السحوبات</th>
                                        <th> حجم التداول</th>
                                        {{--                                        <th> حصة الشريك</th>--}}
                                        <th> حالة الحساب</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <p style="margin: 0;padding: 0px"> {{$transaction['trader-id']}}</p>
                                                <p style="margin: 0;padding: 0px"> {{$transaction['country']}}  </p>
                                                <p style="margin: 0;padding: 0px"> {{$transaction['registery-date']}} </p>
                                            </td>
                                            <td> {{$transaction['balance']}} </td>
                                            <td> {{$transaction['deposits-count']}} </td>
                                            <td> {{$transaction['deposits-sum']}} </td>
                                            <td> {{$transaction['withdrawals-count']}} </td>
                                            <td> {{$transaction['withdrawals-sum']}} </td>
                                            <td> {{$transaction['turnover-clear']}} </td>
                                            {{--                                            <td> {{$transaction['vol-share']}} </td>--}}
                                            <td> @if($transaction['is-closed'] == 0)
                                                    <span class="badge badge-outline-success"> فعال </span>
                                                @else
                                                    <span class="badge badge-outline-danger"> غير فعال </span>
                                                @endif </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Container Fluid -->

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{--    <!-- DataTables JS -->--}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // تحقق ما إذا كان الجدول قد تم تهيئته من قبل
            if ($.fn.DataTable.isDataTable('#table-search')) {
                $('#table-search').DataTable().destroy(); // تدمير التهيئة السابقة
            }
            // تهيئة DataTables من جديد
            $('#table-search').DataTable({
                "searching": false, // إلغاء البحث
                "ordering": true,  // إلغاء الترتيب
                "lengthChange": false,
                "language": {
                    "search": "بحث:",
                    "lengthMenu": "عرض _MENU_ عناصر لكل صفحة",
                    "zeroRecords": "لم يتم العثور على سجلات",
                    "info": "عرض _PAGE_ من _PAGES_",
                    "infoEmpty": "لا توجد سجلات متاحة",
                    "infoFiltered": "(تمت التصفية من إجمالي _MAX_ سجلات)",
                    "paginate": {
                        "previous": "السابق",
                        "next": "التالي"
                    }
                }
            });
        });
    </script>
@endsection

<style>
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 1px 5px !important;
    }
</style>
