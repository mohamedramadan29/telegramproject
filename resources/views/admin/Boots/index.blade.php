@extends('admin.layouts.master')
@section('title')
    البوتات
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
                            <h4 class="card-title flex-grow-1"> البوتات  </h4>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_attribute">
                               اضافة بوت
                                <i class="ti ti-plus"></i>
                            </button>
                            @include('admin.Boots.add')
                        </div>


                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  اسم البوت </th>
                                        <th> المسمي التعريفي </th>
                                        <th>  رابط البوت </th>
                                        <th> ملاحظات </th>
                                        <th> العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php

                                        $i = 1;
                                    @endphp
                                    @foreach($boots as $boot)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td><img width="30px" src="{{asset('assets/admin/images/boot.jpg')}}" alt=""> {{$boot['name']}} </td>
                                            <td> {{$boot['username']}}  </td>
                                            <td><a href="{{$boot['link']}}" class="btn btn-success"> زيارة البوت  </a>  </td>
                                            <td>
                                            {{$boot['notes']}}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-soft-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_withdraw_{{$boot['id']}}">
                                                        <iconify-icon icon="solar:pen-2-broken"
                                                                      class="align-middle fs-18"></iconify-icon>
                                                    </button>

                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_withdraw_{{$boot['id']}}">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                          class="align-middle fs-18"></iconify-icon>
                                                        </button>

                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        @include('admin.Boots.update')
                                        @include('admin.Boots.delete')
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
