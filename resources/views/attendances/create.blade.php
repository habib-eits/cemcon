@extends('tmp')
@section('title', 'Attendance')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                 @if (count($errors) > 0)
                    <div>
                        <div class="alert alert-danger pt-3 pl-0   border-3 bg-danger text-white">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row"> 
                    <div class="col-12">
                        <form action="{{ route('attendances.store') }}" method="POST">
                            @csrf

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Branch <span
                                            class="text-danger">*</span></label>
                                    <select name="branch_id" class="form-select">
                                        <option value="">Select</option>
                                        @foreach ($branches as $value)
                                            <option value="{{ $value->BranchID }}"
                                                {{ old('branch_id') == $value->BranchID ? 'selected' : '' }}>
                                                {{ $value->BranchName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Date  <span
                                        class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="{{ old('date',date('Y-m-d')) }}">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Office Hours  <span
                                        class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="office_hours_per_day" value="{{ old('office_hours_per_day',8) }}">
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Is Holiday <span class="text-danger">*</span></label>
                                    <select name="is_holiday" class="form-select">
                                        <option value="0" {{ old('is_holiday', $row->is_holiday ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_holiday', $row->is_holiday ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>

                           

                            <button type="submit" class="btn btn-success">Submit</button>


                        </form>
                    </div>

                   

                </div>
            </div>
        </div>
    </div>
 @endsection   