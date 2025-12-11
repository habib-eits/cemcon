@extends('template.tmp')
@section('title', 'Lead Edit')
@section('content')
 
   <div class="main-content">

 <div class="page-content">
 <div class="container-fluid">

 @if (session('error'))

 <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                    
                   {{ Session::get('error') }}  
                </div>

@endif

 @if (count($errors) > 0)
                                 
                            <div >
                <div class="alert alert-danger p-1   border-3">
                   <p class="font-weight-bold"> There were some problems with your input.</p>
                    <ul>
                        
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                </div>
 
            @endif

    <div class="content-wrapper">
        <div class="row" style="height: 81vh; overflow: auto;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-info">Edit Lead Details</h3>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal"
                                    data-bs-target=".exampleModal">
                                    Add Notes
                                </button>
                                <a href="{{ url('leads') }}" class="btn btn-primary">Back</a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <small class="text-primary"><em>Input fields marked with * are the required fields</em></small>
                        <hr>
                        <form action="{{ url('updatelead', $lead->id) }}" method="post">
                            @csrf
                            <div class="row"> 
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="name"><strong>Customer/Lead Full Name: *</strong></label>
                                    <input type="text" name="name" id="name" required class="form-control"
                                        value="{{ $lead->name }}">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="tel"><strong>Contact / Email: *</strong></label>
                                    <input type="tel" name="tel" id="tel" required class="form-control"
                                        value="{{ $lead->tel }}">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="tel"><strong>Other Number:</strong></label>
                                    <input type="tel" name="other_tel" id="tel" class="form-control"
                                        value="{{ $lead->other_tel }}">
                                </div>
                                {{-- </div> --}}
                                {{-- <div class="row mt-2"> --}}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="business_details"><strong>Business Details:</strong></label>
                                    <input type="text" name="business_details" id="business_details" class="form-control"
                                        value="{{ $lead->business_details }}">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="service"><strong>Service:</strong></label>
                                    <input type="text" name="service" id="service" class="form-control"
                                        value="{{ $lead->service }}">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="channel"><strong>Channel:</strong></label>
                                    <input type="text" name="channel" id="channel" class="form-control"
                                        value="{{ $lead->channel }}">
                                </div>
                                {{-- </div> --}}
                                {{-- <div class="row mt-2"> --}}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="branch_id"><strong>Branch:</strong></label>
                                    <select name="branch_id" id="branch_id" class="form-select select2">
                                        <option value="" selected>--Select Branch--</option>
                                        @foreach ($branches as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $lead->branch_id == $item->id ? 'selected' : '' }}> {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="branch_service"><strong>Branch Service:</strong></label>
                                    <select name="service_id" id="service_id" class="form-select select2">
                                        <option value="">--Select One--</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $lead->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 {{ $lead->service_id != null ? '' : 'd-none' }}" id="subServiceCol">
                                    <label for="branch_sub_service"><strong>Branch Sub Service:</strong></label>
                                    <select name="sub_service_id" id="sub_service_id" class="form-select select2">
                                        <option value="">--Select One--</option>
                                        @foreach ($subServices as $subservice)
                                            <option value="{{ $subservice->id }}"
                                                {{ $lead->sub_service_id == $subservice->id ? 'selected' : '' }}>
                                                {{ $subservice->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- </div> --}}
                                {{-- <div class="row mt-2"> --}}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="currency"><strong>Currency:</strong></label>
                                    <select name="currency" id="currency" class="form-select select2">
                                        {{-- <option value="" selected>--Select Currency--</option> --}}
                                        <option value="AED" {{ $lead->currency == 'AED' ? 'selected' : '' }}>AED
                                        </option>
                                        <option value="USD" {{ $lead->currency == 'USD' ? 'selected' : '' }}>USD
                                        </option>
                                        {{-- @foreach ($branches as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('currency') == $item->id ? 'selected' : '' }}> {{ $item->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="amount"><strong>Quoted Amount:</strong></label>
                                    <input type="number" step="0.001" name="amount" id="amount" class="form-control"
                                        value="{{ $lead->amount }}">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="agent_id"><strong>Agent:</strong></label>
                                    <select name="agent_id" id="agent_id" class="form-select select2">
                                        <option value="">--Select Agent--</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}"
                                                {{ $lead->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- </div> --}}
                                {{-- <div class="row mt-2"> --}}
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="lead_status"><strong>Campaign:</strong></label>
                                    <select name="campaign_id" id="campaign_id" class="form-select select2">
                                        <option value="">--Select Campaign--</option>
                                        @foreach ($campaigns as $campaign)
                                            <option
                                                value="{{ $campaign->id }}"{{ $lead->campaign_id == $campaign->id ? 'selected' : '' }}>
                                                {{ $campaign->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="lead_status"><strong>Status:</strong></label>
                                    <select name="status" id="lead_status" class="form-select select2"
                                        {{ $lead->status == 'Qualified' ? 'disabled' : '' }}>
                                        <option value="" disabled>--Select Status--</option>
                                        @foreach ($statuses as $status)
                                            <option
                                                value="{{ $status->name }}"{{ $lead->status == $status->name ? 'selected' : '' }}>
                                                {{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 {{ $lead->status == 'Qualified' ? '' : 'd-none' }}"
                                    id="qualifiedStatus">
                                    <label for=""><strong>Qualified Status</strong></label>
                                    <select name="qualified_status" id="qualified_status" class="form-select  ">
                                        @foreach ($Q_statuses as $q_status)
                                            <option value="{{ $q_status->name }}"
                                                {{ $lead->approved_status == $q_status->name ? 'selected' : '' }}>
                                                {{ $q_status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-9 col-sm-12">
                                    <label for="note"><strong>Notes / Remarks:</strong></label><br />
                                    <textarea name="notes" id="" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for=""><strong>Follow Up Date</strong><small>(If Any)</small></label>
                                    <input type="date" name="follow_up_date" id="" class="form-control"
                                        value="">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        @if (count($lead->leadDetails) > 0)
                            <hr>
                            <div class="row mt-2">
                                <div class="col-12 text-center">
                                    <strong>Notes/Remarks</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-2">
                                    <strong>Added By</strong>
                                </div>
                                <div class="col-2">
                                    <strong>Date Added</strong>
                                </div>
                                <div class="col-2">
                                    <strong>Follow Up Date</strong>
                                </div>
                                <div class="col-2">
                                    <strong>Status From</strong>
                                </div>
                                <div class="col-2">
                                    <strong>Status To</strong>
                                </div>
                                <div class="col-2">
                                    <strong>Note/Remarks</strong>
                                </div>
                            </div>
                            <hr>
                            @foreach ($lead->leadDetails as $leadDetail)
                                <div class="row">
                                    <div class="col-2">
                                        <p>{{ 4444}}</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ $leadDetail->date != null ? dmY($leadDetail->date) : 'N/A' }}</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ $leadDetail->follow_up_date != null ? dmY($leadDetail->follow_up_date) : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ $leadDetail->status_from != null ? $leadDetail->status_from : 'N/A' }}</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ $leadDetail->status_to != null ? $leadDetail->status_to : 'N/A' }}</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ $leadDetail->notes }}</p>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Notes / Remarks</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                             
                        </button>
                    </div>
                    <form action="{{ url('addLeadNote') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for=""><strong>Follow Up Date</strong> <small>(if
                                                    any)</small></label>
                                            <input type="date" name="follow_up_date" id=""
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="note"><strong>Notes / Remarks:</strong></label><br />
                                            <textarea name="notes" id="" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#branch_id').change(function() {
                const selectedBranchID = $(this).val();
                if (selectedBranchID != '') {
                    // alert(selectedBranchID);
                    $.ajax({
                        url: '../ajaxGetAgents/' + selectedBranchID,
                        type: 'GET',
                        success: function(response) {
                            if (response.data.length > 0) {
                                const agents = response.data;
                                $('#agent_id').empty();
                                $('#agent_id').append(
                                    '<option value="">--Select Agent--</option>');
                                agents.forEach(agent => {
                                    $('#agent_id').append(
                                        '<option value="' + agent.id + '">' + agent
                                        .name + '</option>'
                                    );
                                    console.log(agent.name);
                                });
                                // Handle the successful response here
                                console.log(response.data.name);
                            } else {
                                $('#agent_id').empty(); // Clear existing options
                                $('#agent_id').append(
                                    '<option value="">--No Agents--</option>');
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            alert(xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    });
                    $.ajax({
                        url: '../ajaxGetServices/' + selectedBranchID,
                        type: 'GET',
                        success: function(response) {
                            if (response.data.length > 0) {
                                const services = response.data;
                                $('#service_id').empty();
                                $('#service_id').append(
                                    '<option value="">--Select Service--</option>');
                                services.forEach(service => {
                                    $('#service_id').append(
                                        '<option value="' + service.id + '">' +
                                        service
                                        .name + '</option>'
                                    );
                                    console.log(service.name);
                                });
                                // Handle the successful response here
                                console.log(response.data.name);
                            } else {
                                $('#service_id').empty(); // Clear existing options
                                $('#service_id').append(
                                    '<option value="">--No Service--</option>');
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            alert(xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    })
                } else {
                    $.ajax({
                        url: '../ajaxGetAgents',
                        type: 'GET',
                        success: function(response) {
                            if (response.data.length > 0) {
                                const agents = response.data;
                                $('#agent_id').empty();
                                $('#agent_id').append(
                                    '<option value="">--Select Agent--</option>');
                                agents.forEach(agent => {
                                    $('#agent_id').append(
                                        '<option value="' + agent.id + '">' + agent
                                        .name + '</option>'
                                    );
                                    console.log(agent.name);
                                });
                                // Handle the successful response here
                                console.log(response.data.name);
                            } else {
                                $('#agent_id').empty(); // Clear existing options
                                $('#agent_id').append(
                                    '<option value="">--No Agents--</option>');
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            alert(xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    });
                    $.ajax({
                        url: '../ajaxGetServices',
                        type: 'GET',
                        success: function(response) {
                            if (response.data.length > 0) {
                                const services = response.data;
                                $('#service_id').empty();
                                $('#service_id').append(
                                    '<option value="">--Select Service--</option>');
                                services.forEach(service => {
                                    $('#service_id').append(
                                        '<option value="' + service.id + '">' +
                                        service
                                        .name + '</option>'
                                    );
                                    console.log(service.name);
                                });
                                // Handle the successful response here
                                console.log(response.data.name);
                            } else {
                                $('#service_id').empty(); // Clear existing options
                                $('#service_id').append(
                                    '<option value="">--No Service--</option>');
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            alert(xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    })
                }

            });
            $('#service_id').change(function() {
                const selectedServiceID = $(this).val();
                if (selectedServiceID != '') {
                    // alert(selectedBranchID);
                    $('#subServiceCol').removeClass('d-none');
                    $.ajax({
                        url: '../ajaxGetSubservices/' + selectedServiceID,
                        type: 'GET',
                        success: function(response) {
                            if (response.data.length > 0) {
                                const subServices = response.data;
                                $('#sub_service_id').empty();
                                $('#sub_service_id').append(
                                    '<option value="">--Select Sub Service--</option>');
                                subServices.forEach(subService => {
                                    $('#sub_service_id').append(
                                        '<option value="' + subService.id + '">' +
                                        subService
                                        .name + '</option>'
                                    );
                                    console.log(subService.name);
                                });
                                // Handle the successful response here
                                // console.log(response.data.name);
                            } else {
                                $('#sub_service_id').empty(); // Clear existing options
                                $('#sub_service_id').append(
                                    '<option value="">--No Sub Services--</option>');
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            alert(xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#sub_service_id').empty();
                    $('#subServiceCol').addClass('d-none');

                }



            });




                $('#agent_id').change(function() {
                if( $(this).val() >0 )
                {
                     
                    $('#lead_status').val('Assigned').change();
 

                }
                else
                {
                    
                    $('#lead_status').val('Pending').change();
                }

                



            });



            $('#lead_status').change(function() {
                const selectedLeadStatus = $(this).val();
                if (selectedLeadStatus == 'Qualified') {
                    $('#qualifiedStatus').removeClass('d-none');
                } else {
                    $('#qualifiedStatus').addClass('d-none');
                    $('#notesDiv').addClass('d-none');
                }
            })
        })
    </script>
@endsection
