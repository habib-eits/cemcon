@extends('template.tmp')

@section('title', 'Employee Section')


@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Employee Detail</h4>

                            <div class="page-title-right">
                                <div class="page-title-right">
                                    <!-- button will appear here -->

                                    <a href="{{ route('employees.index') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-arrow-left  me-1 pt-5"></i>
                                        Go Back
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        {{-- card --}}
                        <div class="col-md-9">
                           @include('employee_details.partials.header')

                           @yield('employee-detail')

                        </div>

                        <div class="col-md-3">
                            @include('employee_details.partials.left_sidebar')

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
