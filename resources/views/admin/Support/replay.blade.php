@extends('admin.layouts.master')
@section('title')
     اضافة رد علي الرسالة
@endsection
@section('css')
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <form method="post" action="{{url('admin/message_replay/add/'.$message['id'])}}" enctype="multipart/form-data">
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
                                <h4 class="card-title"> أضافة رد علي التذكرة بعنوان : {{$message['subject']}} </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> اضافة رد  </label>
                                            <textarea required name="content" class="form-control" id=""
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
{{--                                    <div class="col-lg-12">--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="name" class="form-label"> اضافة المرفقات </label>--}}
{{--                                            <input type="file" multiple id="subject" class="form-control"--}}
{{--                                                   name="images[]"--}}
{{--                                                   value="">--}}
{{--                                            <div class="images">--}}
{{--                                                @php--}}
{{--                                                    $images = explode(',',$support['attachments']);--}}
{{--                                                @endphp--}}
{{--                                                @foreach($images as $image)--}}
{{--                                                    <a target="_blank"--}}
{{--                                                       href="{{url('assets/uploads/support_files/'.$image)}}">--}}
{{--                                                        <img width="80px"--}}
{{--                                                             src="{{asset('assets/uploads/support_files/'.$image)}}"--}}
{{--                                                             alt="">--}}
{{--                                                    </a>--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-secondary w-100"> اضف رد  <i
                                            class='bx bxs-save'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="card" style="padding: 0">
                    @foreach($message_replaies as $replay)
                        <div class="card-body">
                           @if($replay['user_replay'] =='admin')
                               <span class="badge badge-outline-danger"> خدمة العملاء  </span>
                            @else
                               <span class="badge badge-outline-success"> المستخدم  </span>
                           @endif
                               {{$replay['replay']}}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- End Container Fluid -->


        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
@endsection

@section('js')

@endsection
