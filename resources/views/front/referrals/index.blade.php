@extends('front.layouts.master')
@section('title')
     نظام الاحالات الخاص بك
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
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                            <h4 class="card-title flex-grow-1"> قم بدعوة الاصدقاء الى مركز وكالات كيوتيكس واحصل على نسبه ارباح على حجم التداول الكلي عن طريق مشاركه رابط الاحاله الخاص بك  </h4>
                        </div>



                        <div>
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <tbody>
                                    <tr>
                                        <th> رابط الاحالة الخاص بك  </th>
                                        <th>
                                            <a href="{{ url('user/register?ref=' . Auth::user()->referral_code) }}" id="referralLink">
                                                {{ url('user/register?ref=' . Auth::user()->referral_code) }}
                                            </a>
                                            <button class="btn btn-primary btn-sm"
                                                    onclick="copyToClipboard('#referralLink')">
                                                <i class="bx bx-copy"></i>
                                            </button>
                                        </th>
                                    </tr>
                                    </tbody>
                                    <script>
                                        function copyToClipboard(element) {
                                            var temp = document.createElement("textarea");
                                            temp.value = document.querySelector(element).textContent;
                                            document.body.appendChild(temp);
                                            temp.select();
                                            document.execCommand("copy");
                                            document.body.removeChild(temp);
                                            alert("تم نسخ رابط الإحالة!");
                                        }
                                    </script>

                                </table>
                            </div>
                            <!-- end table-responsive -->
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">

{{--                                <h4 class="card-title flex-grow-1"> مجموع حجم التداول للمستخدمين :: {{$transaction_total}}  $   </h4>--}}
{{--                                <h4 class="card-title flex-grow-1">--}}
{{--                                    المستوي الحالي ::--}}
{{--                                    @if (isset(Auth::user()->level) && Auth::user()->level->name)--}}
{{--                                        {{ Auth::user()->level->name }}--}}
{{--                                    @else--}}
{{--                                        بدون مستوي--}}
{{--                                    @endif--}}
{{--                                </h4>--}}
{{--                                <h4 class="card-title flex-grow-1"> حصة الشريك  ::{{$volshare_total}} $ </h4>--}}
{{--                                <h4 class="card-title flex-grow-1">مجموع الارباح  ::{{Auth::user()->earnings}} $ </h4>--}}
                            </div>
                            <h4 class="card-title flex-grow-1"> المستخدمين  </h4>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>  مجموع حجم التداول للمستخدمين  </th>
                                    <th> المستوي الحالي </th>
                                    <th>ربحك  </th>
                                    <th> بونص </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> {{$transaction_total}}  $  </td>
                                    <td>    @if (isset(Auth::user()->level) && Auth::user()->level->name)
                                            {{ Auth::user()->level->name }}
                                        @else
                                            بدون مستوي
                                        @endif
                                    </td>
                                    <td> {{$volshare_total}} $ </td>
                                    <td> {{Auth::user()->earnings}} $ </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  الاسم   </th>
                                        <th>  البريد الالكتروني  </th>
                                        <th> حجم التداول   </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php

                                        $i = 1;
                                    @endphp
                                    @foreach($referrals as $ref)
                                        @php
                                            // جلب جميع trader_id للعميل
                                            $traderIds = \App\Models\front\TraderId::where('user_id', $ref['id'])->pluck('trader_id');
                                            // حساب مجموع حجم التداول المرتبط بالعميل
                                            $totalTurnover = \App\Models\admin\Transaction::whereIn('trader-id', $traderIds)->sum('turnover-clear');
                                        @endphp
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td>{{$ref['name']}}</td>
                                            <td>{{$ref['email']}}</td>
                                            <td> {{ number_format($totalTurnover, 2) }} $</td>

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
                "ordering": false,  // إلغاء الترتيب
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
