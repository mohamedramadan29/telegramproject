@extends('admin.layouts.login_master')
@section('content')
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">

                <div class="col-xxl-7">
                    @if(\Illuminate\Support\Facades\Session::has('Error_Message'))
                        <div class="alert alert-danger"> {{\Illuminate\Support\Facades\Session::get('Error_Message')}} </div>
                    @endif
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="{{url('login')}}" class="logo-dark">
                                        <img src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo dark"> لوجو الموقع
                                    </a>

                                    <a href="{{url('login')}}" class="logo-light">
                                        <img src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo light"> لوجو الموقع
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24"> اعادة تعين كلمة المرور  </h2>

                                <p class="text-muted mt-1 mb-4">  من فضلك ادخل البريد الالكتروني الخاص بك لارسال كود التأكيد  </p>

                                <div class="mb-5">
                                    <form method="post" action="{{url('admin/reset-password')}}"
                                          class="authentication-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني  </label>
                                            <input type="email" id="example-email" name="email"
                                                   class="form-control bg-" placeholder=" البريد الالكتروني  ">
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit"> ارسال  </button>
                                        </div>
                                        <p class="mt-5 text-danger text-center"> الرجوع الي  <a href="{{url('admin/login')}}" class="text-dark fw-bold ms-1"> تسجيل الدخول  </a></p>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden" style="padding:0; border: none;border-radius: 0;box-shadow: none">
                        <div class="d-flex flex-column h-100">
                            <img src="{{asset('assets/admin/images/forex.jpg')}}" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
