@extends('front.layouts.master')
@section('title')
    رابط الاحالة
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
                            <h4 class="card-title flex-grow-1"> رابط الاحالة </h4>
                        </div>


                        <div>
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <tbody>
                                    <tr>
                                        <th> رابط الاحالة</th>
                                        <th>
                                            <a href="https://broker-qx.pro/sign-up/?lid=983427" id="referralLink">
                                                https://broker-qx.pro/sign-up/?lid=983427
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
