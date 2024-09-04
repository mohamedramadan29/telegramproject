@extends('front.layouts.master')
@section('title')
     اضافة تذكرة جديدة
@endsection
@section('css')
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <form method="post" action="{{url('user/message/add')}}" enctype="multipart/form-data" id="newticket">
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
                                <h4 class="card-title"> اضافة تذكرة جديدة </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> عنوان الرسالة <span class="star" style="color: red"> * </span>  </label>
                                            <input required type="text" id="subject" class="form-control" name="subject"
                                                   value="{{old('subject')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> محتوي الرسالة <span class="star" style="color: red"> * </span> </label>
                                            <textarea name="content" class="form-control" id="" rows="4">{{old('content')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> اضافة المرفقات  </label>
                                            <input type="file" multiple id="subject" class="form-control" name="images[]"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" id="submitButton" class="btn btn-outline-secondary w-100">  حفظ <i class='bx bxs-save'></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <script>
                document.getElementById('newticket').addEventListener('submit', function () {
                    var submitbutton = document.getElementById('submitButton');
                    submitbutton.disabled = true;
                    submitbutton.innerHTML = ' جاري الارسال ...'
                });
            </script>
        </div>
        <!-- End Container Fluid -->


        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
@endsection

@section('js')

@endsection
