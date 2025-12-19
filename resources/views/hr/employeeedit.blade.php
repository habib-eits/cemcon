@extends('template.tmp')

@section('title', 'Employee')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Emplyee Edit</h4>
                            <div class="page-title-right">
                                <div class="page-title-right">
                                    <!-- button will appear here <-->
                                    <a href="{{ URL('/Employee') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 w-md"><i
                                            class="mdi mdi-arrow-left pr-3"></i> Go Back</a>
                                    </-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-3">

                        <strong>{{ Session::get('error') }} </strong>
                    </div>
                @endif

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

               <form action="{{ url('/employee/update/' . $employee->EmployeeID) }}" method="POST">
                    <div class="row">

                        {{ csrf_field() }}
                        <input type="hidden" name="EmployeeID" value="{{ $employee->EmployeeID }}" readonly>

                        <div>
                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5">
                                </div>
                                <div class="card-body">
                                    <!-- start of personal detail row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3"><label for="basicpill-firstname-input" class="pr-5">Upload
                                                    Staff Picture</label><br><input type="file" name="UploadSlip"
                                                    id="UploadSlip"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Branch*</label>
                                                <select name="BranchID" id="BranchID" class="form-select">
                                                    <option value="">---Select---</option>
                                                    @foreach ($branch as $value)
                                                        <option value="{{ $value->BranchID }}"
                                                            {{ $employee->BranchID == $value->BranchID ? 'selected=selected' : '' }}>
                                                            {{ $value->BranchName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label" for="pro_IsHafiz">Is Supervisor?

                                                </label>

                                                {{ $employee->IsSupervisor }}

                                            </div>
                                            <div class="form-check form-check-inline pt-1">
                                                <input class="form-check-input" type="radio" name="IsSupervisor"
                                                    id="inlineRadio1" value="Yes"
                                                    {{ $employee->IsSupervisor == 'Yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="IsSupervisor"
                                                    id="inlineRadio2" value="No"
                                                    {{ $employee->IsSupervisor == 'No' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>


                                        <?php
                                        
                                        $StaffType = old('StaffType') ? old('StaffType') : $employee->StaffType;
                                        ?>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Staff Type*</label>
                                                <select name="StaffType" id="StaffType" class="form-select">

                                                    @foreach ($staff_type as $value)
                                                        <option value="{{ $value->StaffType }}"
                                                            {{ $StaffType == $value->StaffType ? 'selected=selected' : '' }}>
                                                            {{ $value->StaffType }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>




                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Title*</label>
                                                <select name="Title" id="Title" class="form-select">

                                                    @foreach ($title as $value)
                                                        <option value="{{ $value->Title }}"
                                                            {{ $employee->Title == $value->Title ? 'selected=selected' : '' }}>
                                                            {{ $value->Title }}</option>
                                                    @endforeach


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Name*</label>
                                                <input type="text" class="form-control" name="FirstName"
                                                    value="{{ $employee->FirstName }}">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Middle Name*</label>
                                                <input type="text" class="form-control" name="MiddleName"
                                                    value="{{ $employee->MiddleName }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Last Name*</label>
                                                <input type="text" class="form-control" name="LastName"
                                                    value="{{ $employee->LastName }} ">
                                            </div>


                                        </div>

                                        <?php
                                        $DateOfBirth = date('d/m/Y', strtotime(str_replace('-', '/', $employee->DateOfBirth))); ?>

                                        <div class="col-md-4">
                                          <div class="mb-3">
                                                <label for="input-date1">
                                                    Date of Birth <span class="text-danger">*</span>
                                                </label>

                                                <input type="date"
                                                      name="DateOfBirth"
                                                      id="input-date1"
                                                      class="form-control"
                                                      value="{{ old('DateOfBirth', optional($employee)->DateOfBirth) }}">

                                                <span class="text-muted">Select your date of birth</span>
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Gender*</label>
                                                <select name="Gender" id="Gender" class="form-select">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Email*</label>
                                                <input type="text" class="form-control" name="Email"
                                                    value="{{ $employee->Email }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Password*</label>
                                                <input type="text" class="form-control" name="Password"
                                                    value="{{ $employee->Password }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Nationality</label>
                                                <select name="Nationality" id="Nationality" class="form-select select2">
                                                    @foreach ($country as $value)
                                                        <option value="{{ $value->CountryName }}"
                                                            {{ $employee->Nationality == $value->CountryName ? 'selected=selected' : '' }}>
                                                            {{ $value->CountryName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Mobile No*</label>
                                                <input type="text" class="form-control" name="MobileNo"
                                                    value="{{ $employee->MobileNo }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Home Phone*</label>
                                                <input type="text" class="form-control" name="HomePhone"
                                                    value="{{ $employee->HomePhone }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Full Address*</label>
                                                <input type="text" class="form-control" name="FullAddress"
                                                    value="{{ $employee->FullAddress }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Education Level*</label>
                                                <select name="EducationLevel" id="EducationLevel" class="form-select">

                                                    @foreach ($educationlevel as $value)
                                                        <option value="{{ $value->EducationLevelName }}"
                                                            {{ $employee->EducationLevel == $value->EducationLevelName ? 'selected' : '' }}>
                                                            {{ $value->EducationLevelName }}
                                                        </option>
                                                    @endforeach


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Last Degree</label>
                                                <input type="text" class="form-control" name="LastDegree"
                                                    value="{{ $employee->LastDegree }} ">
                                            </div>


                                        </div>
                                    </div>
                                    <!-- end of personal detail row -->
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5">
                                    Marital Detail
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Marital Status*</label>
                                                <select name="MaritalStatus" id="MaritalStatus" class="form-select">
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 d-none">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">SSNorGID*</label>
                                                <input type="text" class="form-control" name="SSNorGID"
                                                    value="{{ $employee->SSNorGID }} ">
                                            </div>


                                        </div>


                                        <div class="clearfix"></div>



                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Spouse Name</label>
                                                <input type="text" class="form-control" name="SpouseName"
                                                    value="{{ $employee->SpouseName }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Spouse Address</label>
                                                <input type="text" class="form-control" name="SpouseEmployer"
                                                    value="{{ $employee->SpouseEmployer }}">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Spouse Work Phone</label>
                                                <input type="text" class="form-control" name="SpouseWorkPhone"
                                                    value="{{ $employee->SpouseWorkPhone }} ">
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                            
                            $VisaIssueDate = dateformatman($employee->VisaIssueDate);
                            $VisaExpiryDate = date('d/m/Y', strtotime(str_replace('-', '/', $employee->VisaExpiryDate)));
                            
                            $PassportExpiry = date('d/m/Y', strtotime(str_replace('-', '/', $employee->PassportExpiry)));
                            
                            $EidExpiry = date('d/m/Y', strtotime(str_replace('-', '/', $employee->EidExpiry)));
                            
                            ?>


                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5">
                                    Visa / Passport Section
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <label for="visa-issue-date">Visa Issue Date <span class="text-danger">*</span></label>

                                                <input type="date"
                                                      name="VisaIssueDate"
                                                      id="visa-issue-date"
                                                      class="form-control"
                                                      value="{{ old('VisaIssueDate', optional($employee)->VisaIssueDate ? \Carbon\Carbon::parse($employee->VisaIssueDate)->format('Y-m-d') : '') }}">

                                                <span class="text-muted">Select visa issue date</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Visa Expiry Date*</label>


                                               <input type="date"
                                                      name="VisaExpiryDate"
                                                      id="visa-expiry-date"
                                                      class="form-control"
                                                      value="{{ old('VisaExpiryDate', optional($employee)->VisaExpiryDate ? \Carbon\Carbon::parse($employee->VisaExpiryDate)->format('Y-m-d') : '') }}">

                                                <span class="text-muted">Select visa expiry date</span>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Passport No*</label>


                                                <input name="PassportNo" id="input-date1" class="form-control"
                                                    value="{{ $employee->PassportNo }}">
                                            </div>

                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Passport Expiry*</label>


                                                <input type="date"
                                                      name="PassportExpiry"
                                                      id="passport-expiry-date"
                                                      class="form-control"
                                                      value="{{ old('PassportExpiry', optional($employee)->PassportExpiry ? \Carbon\Carbon::parse($employee->PassportExpiry)->format('Y-m-d') : '') }}">

                                                <span class="text-muted">Select passport expiry date</span>



                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Emirates ID No</label>


                                                <input name="EidNo" class="form-control"
                                                    value="{{ $employee->EidNo }}">
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Eid Expiry*</label>


                                                <input type="date"
                                                      name="EidExpiry"
                                                      id="eid-expiry-date"
                                                      class="form-control"
                                                      value="{{ old('EidExpiry', optional($employee)->EidExpiry ? \Carbon\Carbon::parse($employee->EidExpiry)->format('Y-m-d') : '') }}">

                                                <span class="text-muted">Select EID expiry date</span>



                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>




                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5">
                                    Next of Kin
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Next of Kin Name*</label>
                                                <input type="text" class="form-control" name="NextofKinName"
                                                    value="{{ $employee->NextofKinName }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Next of Kin Address*</label>
                                                <input type="text" class="form-control" name="NextofKinAddress"
                                                    value="{{ $employee->NextofKinAddress }} ">
                                            </div>


                                        </div>


                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Next of Kin Phone*</label>
                                                <input type="text" class="form-control" name="NextofKinPhone"
                                                    value="{{ $employee->NextofKinPhone }} ">
                                            </div>


                                        </div>


                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Next of Kin Relationship*</label>
                                                <input type="text" class="form-control" name="NextofKinRelationship"
                                                    value="{{ $employee->NextofKinRelationship }} ">
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5  ">
                                    Offical Details
                                </div>
                                <div class="card-body">
                                    <div class="row">


                                        <div class="clearfix"></div>


                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Job Title</label>
                                                <select name="JobTitleID" id="JobTitleID" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach ($jobtitle as $value)
                                                        <option value="{{ $value->JobTitleID }}"
                                                            {{ $employee->JobTitleID == $value->JobTitleID ? 'selected=selected' : '' }}>
                                                            {{ $value->JobTitleName }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Department*</label>
                                                <select name="DepartmentID" id="DepartmentID" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach ($department as $value)
                                                        <option value="{{ $value->DepartmentID }}"
                                                            {{ $employee->DepartmentID == $value->DepartmentID ? 'selected=selected' : '' }}>
                                                            {{ $value->DepartmentName }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Supervisor</label>
                                                <select name="SupervisorID" id="SupervisorID"
                                                    class="form-select select2">
                                                    <option value="">---Select---</option>
                                                    @foreach ($supervisor as $value)
                                                        <option value="{{ $value->EmployeeID }}"
                                                            {{ $employee->SupervisorID == $value->EmployeeID ? 'selected=selected' : '' }}>
                                                            {{ $value->full_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Work Location*</label>
                                                <input type="text" class="form-control" name="WorkLocation"
                                                    value="{{ $employee->WorkLocation }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Email Offical*</label>
                                                <input type="text" class="form-control" name="EmailOffical"
                                                    value="{{ $employee->EmailOffical }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Work Phone*</label>
                                                <input type="text" class="form-control" name="WorkPhone"
                                                    value="{{ $employee->WorkPhone }} ">
                                            </div>


                                        </div>

                                        <?php
                                        
                                        $StartDate = date('d/m/Y', strtotime(str_replace('-', '/', $employee->StartDate)));
                                        
                                        ?>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Date of Joining*</label>
                                                <input type="date"
                                                      name="StartDate"
                                                      id="start-date"
                                                      class="form-control"
                                                      value="{{ old('StartDate', optional($employee)->StartDate ? \Carbon\Carbon::parse($employee->StartDate)->format('Y-m-d') : '') }}">

                                                <span class="text-muted">Select start date</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Salary*</label>
                                                <input type="text" class="form-control" name="Salary"
                                                    value="{{ $employee->Salary }} ">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Salary Comission (If Any)</label>
                                                <input type="text" class="form-control" name="ExtraComission"
                                                    value="{{ $employee->ExtraComission }} ">
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Salary Remarks*</label>
                                                <input type="text" class="form-control" name="SalaryRemarks"
                                                    value="{{ $employee->SalaryRemarks }} ">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-transparent border-bottom h5">
                                    Bank Details
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Bank Name </label>
                                                <input type="text" class="form-control" name="BankName"
                                                    value="{{ $employee->BankName }} ">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">IBAN # </label>
                                                <input type="text" class="form-control" name="IBAN"
                                                    value="{{ $employee->IBAN }} ">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Account Title </label>
                                                <input type="text" class="form-control" name="AccountTitle"
                                                    value="{{ $employee->AccountTitle }} ">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input">Salary Type </label>
                                                <select name="SalaryTypeID" class="form-select">
                                                    @foreach ($salary_type as $value)
                                                        <option value="{{ $value->SalaryTypeID }}"
                                                            {{ $value->SalaryTypeID == $employee->SalaryTypeID ? 'selected=selected' : '' }}>
                                                            {{ $value->SalaryType }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div><button type="submit" class="btn btn-success w-lg float-right">Save /
                                                Update</button>
                                            <a href="{{ URL('/EmployeeDetail') }}"
                                                class="btn btn-secondary w-lg float-right">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                </form>
            </div> <!-- container-fluid -->
        </div>
    @endsection
