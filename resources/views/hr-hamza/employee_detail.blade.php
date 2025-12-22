@extends('template.tmp')
@section('title', 'Emplyee Section')
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
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                            class="mdi mdi-arrow-left  me-1 pt-5"></i> Go Back</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-9">
                        @if (session('error'))
                            <div class="alert alert-{{ Session::get('class') }} p-3 ">

                                {{ Session::get('error') }}
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

                        @include('hr-hamza.emp.emp_info')

                        <form action="{{ URL('/EmployeeUpdate') }}" method="post" enctype="multipart/form-data">
                            <div class="row">
                                {{ csrf_field() }}
                                <input type="hidden" name="EmployeeID" value="27" readonly="">

                                <div>
                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5">
                                            Personal Information
                                        </div>
                                        <div class="card-body">
                                            <!-- start of personal detail row -->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">Branch</td>
                                                    <td class="col-md-6">{{ $employee->BranchName }}</td>

                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Title</td>
                                                    <td>{{ $employee->Title }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">First Name</td>
                                                    <td>{{ $employee->FirstName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Middle Name</td>
                                                    <td>{{ $employee->MiddleName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Last Name</td>
                                                    <td>{{ $employee->LastName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Date of Birth</td>
                                                    <td>{{ dateformatman($employee->DateOfBirth) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Is Supervisor</td>
                                                    <td>Yes</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Gender</td>
                                                    <td>{{ $employee->Gender }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Email</td>
                                                    <td>{{ $employee->Email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Password</td>
                                                    <td class="text-success">{{ $employee->Password }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Nationality</td>
                                                    <td>{{ $employee->Nationality }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">MobileNo</td>
                                                    <td>{{ $employee->MobileNo }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Home Phone</td>
                                                    <td>{{ $employee->HomePhone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Full Address</td>
                                                    <td>{{ $employee->FullAddress }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Education Level</td>
                                                    <td>{{ $employee->EducationLevel }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Last Degree</td>
                                                    <td>{{ $employee->LastDegree }}</td>
                                                </tr>

                                            </table>

                                            <div class="row">


                                            </div>
                                            <!-- end of personal detail row -->
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5">
                                            Marital Detail
                                        </div>
                                        <div class="card-body">

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">MaritalStatus</td>
                                                    <td class="col-md-6">{{ $employee->MaritalStatus }}</td>

                                                </tr>
                                                <tr class="d-none">
                                                    <td class="fw-bold">SSNorGID</td>
                                                    <td>{{ $employee->SSNorGID }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Spouse Name</td>
                                                    <td>{{ $employee->SpouseName }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="fw-bold">Spouse Address</td>
                                                    <td>{{ $employee->SpouseEmployer }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Spouse Work Phone</td>
                                                    <td>{{ $employee->SpouseWorkPhone }}</td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5">
                                            Visa / Passport Section
                                        </div>
                                        <div class="card-body">

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">Visa Issue Date</td>
                                                    <td class="col-md-6">{{ dateformatman($employee->VisaIssueDate) }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Visa Expiry Date</td>
                                                    <td>{{ dateformatman($employee->VisaExpiryDate) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Passport No</td>
                                                    <td>{{ $employee->PassportNo }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="fw-bold">Passport Expiry</td>
                                                    <td>{{ dateformatman($employee->PassportExpiry) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Emirates ID No</td>
                                                    <td>{{ $employee->EidNo }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Eid Expiry</td>
                                                    <td>{{ dateformatman($employee->EidExpiry) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5">
                                            Next of Kin
                                        </div>
                                        <div class="card-body">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">Next of Kin Name</td>
                                                    <td class="col-md-6">{{ $employee->NextofKinName }}</td>

                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Next of Kin Address</td>
                                                    <td>{{ $employee->NextofKinAddress }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Next of KinPhone</td>
                                                    <td>{{ $employee->NextofKinPhone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Next of Kin Relationship</td>
                                                    <td>{{ $employee->NextofKinRelationship }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5">
                                            Bank Details
                                        </div>
                                        <div class="card-body">

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">Bank Name</td>
                                                    <td class="col-md-6">{{ $employee->BankName }}</td>

                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">IBAN #</td>
                                                    <td>{{ $employee->IBAN }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Account Title</td>
                                                    <td>{{ $employee->AccountTitle }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="fw-bold">Salary Type</td>
                                                    <td>{{ $employee->SalaryTypeTitle }}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-transparent border-bottom h5  ">
                                            Offical Details
                                        </div>
                                        <div class="card-body">

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                class="table table-striped table-sm table-responsive">
                                                <tr>
                                                    <td class="fw-bold col-md-3">Job Title</td>
                                                    <td class="col-md-6">{{ $employee->JobTitleName }}</td>

                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Department </td>
                                                    <td>{{ $employee->DepartmentName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Supervisor</td>
                                                    <td>{{ supervisor_name($employee->SupervisorID) }}</td>
                                                </tr>



                                                <tr>
                                                    <td class="fw-bold">Work Location</td>
                                                    <td>{{ $employee->WorkLocation }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Email Offical</td>
                                                    <td>{{ $employee->EmailOffical }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Work Phone</td>
                                                    <td>{{ $employee->WorkPhone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Date of Joining</td>
                                                    <td>{{ dateformatman($employee->StartDate) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Salary</td>
                                                    <td>{{ $employee->Salary }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Comisison (If Any)</td>
                                                    <td>{{ $employee->ExtraComission }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Salary Remarks (If Any)</td>
                                                    <td>{{ $employee->SalaryRemarks }}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                        </form>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <!-- employee detail side bar -->
                    @include('template.emp_sidebar_hamza', ['employeeId' => $employee->EmployeeID])
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    @endsection
