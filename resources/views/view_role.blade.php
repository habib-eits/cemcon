@extends('template.tmp')

@section('title', $pagetitle)

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">User Rights & Control</h4>
                        <div class="page-title-right">
                            <!-- button will appear here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- enctype="multipart/form-data" -->
            <form action="{{ URL('/RoleUpdate') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="basicpill-firstname-input">User*</label>
                                            <select name="UserID" id="UserID" class="form-select">
                                                @foreach($users as $value)
                                                <option value="{{ $value->UserID }}" {{ old('UserID') == $value->UserID ? 'selected' : '' }}>{{ $value->FullName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <input type="checkbox" id="checkAll" name="checkAll">
                                <label>Check All</label>
                                <hr>

                                @foreach ($role as $roleItem)
                                <h4 class="bg bg-light p-1">{{ $roleItem->Table }}</h4>
                                <div class="row">
                                    @foreach (DB::table('role')->where('Table', $roleItem->Table)->get() as $permission)
                                    @php
                                        $result = check_role1($users[0]->UserID, $permission->Table, $permission->Action);
                                    @endphp
                                    <div class="col-sm-2 mt-2 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input name="Check[]" type="checkbox" class="custom-control-input" id="{{ $permission->RoleID }}" value="Y" {{ isset($result[0]->Allow) && $result[0]->Allow == 'Y' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck{{ $permission->RoleID }}">{{ $permission->Action }}</label>
                                            <input name="TableName[]" type="hidden" id="{{ $permission->RoleID }}" value="{{ $roleItem->Table }}">
                                            <input name="Action[]" type="hidden" id="{{ $permission->RoleID }}" value="{{ $permission->Action }}">
                                            <input name="Allow[]" type="hidden" id="{{ $permission->RoleID }}Allow" value="{{ isset($result[0]->Allow) ? $result[0]->Allow : 'N' }}" class="role">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach

                                <div>
                                    <button type="submit" class="btn btn-success w-lg float-right">Save / Update</button>
                                    <a href="{{ URL('/') }}" class="btn btn-secondary w-lg float-right">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('input[type="checkbox"]').change(function() {
            var id = $(this).attr('id');
            if ($(this).is(':checked')) {
                $('#' + id + 'Allow').val('Y');
            } else {
                $('#' + id + 'Allow').val('N');
            }
        });

        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', this.checked);
            if (this.checked) {
                $(".role").val('Y');
            } else {
                $(".role").val('N');
            }
        });
    });
</script>

@endsection
