@extends('admin.layouts.master')
@section('title')
    تفاصيل التذكرة
@endsection
@section('css')
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <form method="post" action="{{url('admin/message/update/'.$support['id'])}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 ">
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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> تفاصيل التذكرة </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> عنوان الرسالة </label>
                                            <input readonly disabled required type="text" id="subject"
                                                   class="form-control"
                                                   name="subject"
                                                   value="{{$support['subject']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> محتوي الرسالة </label>
                                            <textarea readonly disabled name="content" class="form-control" id=""
                                                      rows="4">{{$support['content']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> اضافة المرفقات </label>
                                            <input type="file" multiple id="subject" class="form-control"
                                                   name="images[]"
                                                   value="">
                                            <div class="images">
                                                @php
                                                    $images = explode(',',$support['attachments']);
                                                @endphp
                                                @foreach($images as $image)
                                                    <a target="_blank"
                                                       href="{{url('assets/uploads/support_files/'.$image)}}">
                                                        <img width="80px"
                                                             src="{{asset('assets/uploads/support_files/'.$image)}}"
                                                             alt="">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> تعديل الحالة </label>
                                            <select name="status" class="form-control" id="">
                                                <option @if($support['status'] == 0) selected @endif value="0"> تحت
                                                    المراجعه
                                                </option>
                                                <option @if($support['status'] == 1) selected @endif value="1"> تم
                                                    الرد
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-secondary w-100"> تعديل <i
                                            class='bx bxs-save'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Container Fluid -->


        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
@endsection

@section('js')

@endsection
