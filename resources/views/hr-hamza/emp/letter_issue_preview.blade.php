@extends('template.tmp')

@section('title', 'Issue Letter')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Issue Letter</h4>
                            <div class="page-title-right">
                                <div class="page-title-right">
                                    <!-- You can add a back button here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Success/Error Message -->
                @if (session('error'))
                    <div class="alert alert-{{ session('class', 'success') }} alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">

                        <!-- Issue Letter Form -->
                        <form action="{{ route('employee.letters.store', $employee->EmployeeID) }}" method="post">
                            @csrf

                            <div class="card">
                                <div class="card-body">

                                    <!-- Hidden Fields -->
                                    <input class="form-control" type="hidden" name="EmployeeID"
                                        value="{{ $employee->EmployeeID }}" required>

                                    <input class="form-control" type="hidden" name="LetterID"
                                        value="{{ $letter->LetterID }}" required>

                                    <h4 class="card-title">Letter Template</h4>
                                    <p class="card-title-desc"></p>

                                    <!-- Title Field -->
                                    <div class="mb-3 row">
                                        <label for="Title" class="col-md-2 col-form-label">Title</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="Title" id="Title"
                                                required value="{{ $letter->Title }}">
                                        </div>
                                    </div>

                                    <!-- Content Editor -->
                                    <div class="mb-3 row">
                                        <label for="Content" class="col-md-2 col-form-label">Content</label>
                                        <div class="col-md-10">
                                            <textarea id="basic-example" name="Content">
@php
    $content = $letter->Content;

    // Replace placeholders with actual employee data
    $content = str_replace(
        '^FullName^',
        trim($employee->FirstName . ' ' . $employee->MiddleName . ' ' . $employee->LastName),
        $content,
    );
    $content = str_replace('^Passport^', $employee->PassportNo ?? '', $content);
    $content = str_replace('^FirstName^', $employee->FirstName, $content);
    $content = str_replace('^Designation^', $employee->JobTitleName ?? '', $content);
    $content = str_replace('^Location^', $employee->BranchName ?? '', $content);
    $content = str_replace('^Nationality^', $employee->Nationality ?? '', $content);
    $content = str_replace('^Salary^', $employee->Salary ?? '', $content);
    $content = str_replace('^DATE^', date('d-m-Y'), $content);

    echo $content;
@endphp
                                        </textarea>

                                            <!-- TinyMCE Editor -->
                                            <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
                                            <script>
                                                tinymce.init({
                                                    selector: 'textarea#basic-example',
                                                    height: 500,
                                                    menubar: false,
                                                    plugins: [
                                                        'advlist autolink lists link image charmap print preview anchor textcolor',
                                                        'searchreplace visualblocks code fullscreen',
                                                        'insertdatetime media table contextmenu paste code help wordcount'
                                                    ],
                                                    mobile: {
                                                        theme: 'mobile'
                                                    },
                                                    toolbar: 'insert | undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                    content_css: [
                                                        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                        '//www.tiny.cloud/css/codepen.min.css'
                                                    ]
                                                });
                                            </script>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <input type="submit" class="btn btn-primary w-md" value="Issue Letter">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
