@extends('tmp')
@section('title', $pagetitle)

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->

                <!-- enctype="multipart/form-data" -->
                <form action="{{ URL('/ExpenseSave') }}" method="post" class="custom-validation">


                    <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">


                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                     <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Supplier </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="SupplierID" id="SupplierID" class="form-select select2 mt-5"
                                                required="">
                                                <option value="">Select</option>
                                                @foreach ($supplier as $key => $value)
                                                    <option value="{{ $value->SupplierID }}">{{ $value->SupplierName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Job No </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="JobID" id="JobID" class="form-select select2 mt-5">
                                                <option value="">Select</option>
                                                @foreach ($job as $key => $value)
                                                    <option value="{{ $value->JobID }}">{{ $value->JobNo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Paid Through </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="ChartOfAccountID_From" id="ChartOfAccountID_From"
                                                class="form-select form-control-sm select2"
                                                style="width: 100% !important;" required="">
                                                <option value="">select</option>
                                                @foreach ($chartOfAccountFrom as $key => $value)
                                                    <option value="{{ $value->ChartOfAccountID }}">
                                                        {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Ref # </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="ReferenceNo" autocomplete="off"
                                                    class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Tax Type # </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="TaxType" id="TaxType" class="form-select">
                                                    <option selected value="exclusive">exclusive</option>
                                                    <option value="inclusive">inclusive</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">



                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Expense #
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div id="invoict_type"> <input type="text" name="ExpenseNo"
                                                        autocomplete="off" class="form-control"
                                                        value="{{ $expenseNo }}" readonly></div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="date" name="Date" class="form-control"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <hr class="invoice-spacing">

                            <div class='text-center'>

                            </div>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table>
                                        <thead>
                                            <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                <th width="2%" class="text-center"><input id="check_all"
                                                        type="checkbox" /></th>
                                                <th width="20%">EXPENSE ACCOUNT </th>
                                                <th width="33%">NOTES </th>
                                                <th width="10%">Amount</th>
                                                <th width="10%">Tax</th>
                                                <th width="10%">Tax Val</th>
                                                <th width="15%">Total </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                           <div class="row mt-1 mb-2" style="margin-left: 29px;">
                                <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                    <button class="btn btn-danger delete" id="deleteRow" type="button"><i
                                            class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                    <button class="btn btn-success addmore" id="addRow" type="button"><i
                                            class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>
                                </div>

                                <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3'>
                                    <div id="result"></div>
                                </div>
                                <br>

                            </div>



                            <div class="row mt-4">

                                <div class="col-lg-8 col-12">

                                {{-- 
                                    <label for="" class="mt-2">Description</label>
                                    <textarea class="form-control" rows='5' name="DescriptionNotes" id="note"
                                        placeholder="Description notes if any."></textarea> --}}

                                </div>
                                <div class="col-lg-4 col-12 ">
                                    <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->

                                    <div class="form-group mt-1">
                                        <label>Total Before VAT: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                            <input type="number" step="0.01" class="form-control" id="TotalBeforeTax"
                                                name="TotalBeforeTax" readonly />


                                        </div>
                                    </div>



                                    <div class="form-group mt-1">
                                        <label>Tax Amount: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                            <input type="number" step="0.01" class="form-control" id="TotalTax"
                                                name="TotalTax" readonly />
                                        </div>
                                    </div>




                                    <div class="form-group mt-1">
                                        <label>Grand Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                            <input type="number" step="0.01" class="form-control" id="GrandTotal"
                                                name="GrandTotal" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-2"><button type="submit"
                                    class="btn btn-success w-md float-right">Update</button>
                                <a href="{{ URL('/DeliveryChallan') }}"
                                    class="btn btn-secondary w-md float-right">Cancel</a>

                            </div>



                </form>




            </div>
        </div>
    </div>



    <script>

        $(document).ready(function () {
            $('#addRow').trigger('click');

           
        });
         $("#addRow").on("click", function() {

                let newRow = `
                <tr>
                        <td class="p-1"><input class="case" type="checkbox" /></td>

                            <td>
                            <select name="ChartOfAccountID[]" class="form-control coa-select select2"
                                style="width:100%">
                                <option value="">select</option>
                                @foreach ($expenseAccounts as $row)
                                    <option value="{{ $row->ChartOfAccountID }}">{{ $value->ChartOfAccountID.' - '.$row->ChartOfAccountName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text" name="Notes[]" class="row-notes form-control">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="Amount[]"
                                class="row-amount form-control" value="">
                        </td>
                        <td>
                            <select name="TaxPer[]" class="form-select row-tax-per-select">
                                <option selected value="0">0</option>
                                <option value="5">5%</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" step="0.01" name="Tax[]"
                                class="row-tax form-control" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="Total[]"
                                class="row-total form-control" readonly>
                        </td>
                        
                    </tr>
                `;

                $("table tbody").append(newRow);
                $('.select2').select2();

            });

        $("#deleteRow").on("click", function() {
            $(".case:checked").closest("tr").remove();
            calculateSummary();
        });


        $(document).on('change input', '.row-amount, .row-tax-per-select', function (e) { 
            let row = $(this).closest('tr');
            calculateRow(row);
            
        });


        function calculateRow(row)
        {
            const taxType =  $('#TaxType').val();

            const amount = parseFloat(row.find('.row-amount').val()) || 0;
            const taxPer = parseInt(row.find('.row-tax-per-select').val()) || 0;
            let total = amount;
            let taxValue = 0;

            if(taxPer > 0 && taxType == 'exclusive'){
                taxValue = calculateTaxExclusive(amount, taxPer);
                total = amount;
            }

            if(taxPer > 0 && taxType == 'inclusive'){
                taxValue = calculateTaxInclusive(amount, taxPer);
                total = amount - taxValue;
            }
           
            row.find('.row-tax').val(taxValue.toFixed(2));
            row.find('.row-total').val(total.toFixed(2));

            calculateSummary();

        }

        function calculateTaxInclusive(amount, taxPer) {
            let inclusive = 0;
            inclusive = parseFloat((amount * taxPer) / (100 + taxPer));
            return inclusive;
        }
        function calculateTaxExclusive(value, tax)
        {
            let exclusive = 0
            exclusive = parseFloat((tax/100) * value);
            return exclusive;
        }


        $('#TaxType').on('change', function(){

            $('table tbody tr').each(function(){
                let row = $(this);
                calculateRow(row);
            });

        });



        function calculateSummary()
        {
            let totalBeforeTax = 0;
            let totalTax = 0;
            let grandTotal = 0;
            
            $('.row-total').each(function(){ 
                let value = parseFloat($(this).val()) || 0; 
                totalBeforeTax+= value;
            });
            $('#TotalBeforeTax').val(totalBeforeTax);

            $('.row-tax').each(function(){ 
                let value = parseFloat($(this).val()) || 0; 
                totalTax+= value;
            });
            $('#TotalTax').val(totalTax);

            grandTotal = totalBeforeTax + totalTax;
            $('#GrandTotal').val(grandTotal.toFixed(2));
        }
    </script>
















@endsection
