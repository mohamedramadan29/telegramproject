@extends('front.layouts.master')
@section('title')
    مستوي الاحالات
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

                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                            <h4 class="card-title flex-grow-1"> مستوي الاحالات   </h4>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  المستوي  </th>
                                        <th> حجم التداول  </th>
                                        <th>   نسبة ال vol-share </th>
                                        <th>   bouns  </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($levels as $level)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td>{{$level['name']}}</td>
                                            <td> {{$level['turnover']}} $ </td>
                                            <td> {{$level['percent_volshare']}} % </td>
                                            <td> {{$level['Bonus']}} $ </td>

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
