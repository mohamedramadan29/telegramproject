@extends('admin.layouts.master')
@section('title')
   الاسئلة الشائعه
@endsection
@section('css')
    {{--    <!-- DataTables CSS -->--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card overflow-hidden" style="background: url({{asset('assets/admin/images/faqs.jpg')}});">
                        <div class="position-absolute top-0 end-0 bottom-0 start-0 bg-dark opacity-75"></div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 text-center">
                                    <h3 class="text-white"> الاسئلة الشائعه  </h3>
                                    <p class="text-white-50"> جميع الاسئلة التي تريدها لمساعدتك  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-xl-4">
                                <div class="col-12">
                                    <!-- FAQs -->
                                    <div class="accordion">
                                        @foreach($faqs as $faq)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq_{{$faq['id']}}" aria-expanded="false" aria-controls="faq_{{$faq['id']}}">
                                                       {{$faq['title']}}
                                                    </button>
                                                </h2>
                                                <div id="faq_{{$faq['id']}}" class="accordion-collapse collapse" aria-labelledby="faq_{{$faq['id']}}">
                                                    <div class="accordion-body">
                                                        {!! $faq['content'] !!}
                                                    </div>
                                                    <div>
                                                        <a href="#" class="btn btn-soft-success btn-sm">  <iconify-icon icon="solar:pen-2-broken"
                                                                                                            class="align-middle fs-18"></iconify-icon> </a>
                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_withdraw_{{$faq['id']}}">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                          class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </div>
                                                    <br>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div> <!-- end row-->

                            <div class="row my-5">
                                <div class="col-12 text-center">
                                    <h4> لم اجد ما  ابحث عنة ؟ </h4>
                                    <a href="{{url('admin/message/add')}}" type="button" class="btn btn-success mt-2"><i class="bx bx-envelope me-1"></i> تواصل معنا  </a>
                                </div>
                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>

        </div>
        <!-- End Container xxl -->

    </div>

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
