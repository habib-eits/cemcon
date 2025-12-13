@extends('tmp')
@section('title', $pagetitle)

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <script src="{{ asset('assets/invoice/js/jquery-1.11.2.min.js') }}"></script>
                                <script src="{{ asset('assets/invoice/js/jquery-ui.min.js') }}"></script>
                                <script src="js/ajax.js"></script> -->
    <!--
                                <script src="{{ asset('assets/invoice/js/bootstrap.min.js') }}"></script>
                                <script src="{{ asset('assets/invoice/js/bootstrap-datepicker.js') }}"></script>  -->


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- multipe image upload  -->
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">

    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


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
                                                <?php foreach ($supplier as $key => $value) : ?>
                                                <option value="{{ $value->SupplierID }}">{{ $value->SupplierName }}</option>
                                                <?php endforeach ?>
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
                                                <?php foreach ($job as $key => $value) : ?>
                                                <option value="{{ $value->JobID }}">{{ $value->JobNo }}</option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-1 row d-none" id="WalkinCustomer">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">or Walkin Customer
                                            </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="WalkinCustomerName"
                                                value="" placeholder="Walkin cusomter" id="1WalkinCustomerName">

                                        </div>
                                    </div>



                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Paid Through </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="ChartOfAccountID_From" id="ChartOfAccountID_From"
                                                class="form-select form-control-sm select2   "
                                                style="width: 100% !important;" required="">
                                                <option value="">select</option>
                                                @foreach ($items as $key => $value)
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
                                    <!-- Expense Type Dropdown -->
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger">Tax Type</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="TaxType" id="tax_type" class="form-select">
                                                    <option value="exclusive" selected>Exclusive</option>
                                                    <option value="inclusive">Inclusive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 row d-none">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Tax</label><i
                                                class="fa fa-info-circle" data-toggle="tooltip" data-placement="left"
                                                title="Use this option after creating complete Invoice."></i>
                                        </div>

                                        <div class="col-sm-9">
                                            <select name="UserI D" id="seletedVal" class="form-select"
                                                onchange="GetSelectedTextValue(this)">
                                                <?php foreach ($tax as $key => $valueX1) : ?>
                                                <option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}
                                                </option>
                                                <?php endforeach ?>

                                            </select>
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
                                                        value="EXP-{{ $vhno[0]->VHNO }}" readonly></div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="email-id">Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group" id="datepicker21">
                                                    <input type="text" name="Date" autocomplete="off"
                                                        class="form-control" placeholder="yyyy-mm-dd"
                                                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker21"
                                                        data-provide="datepicker" data-date-autoclose="true"
                                                        value="{{ date('Y-m-d') }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12" id="paymentdetails">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Cheque Details
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="PaymentDetails" class="form-control ">

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
                                                <th width="1%">EXPENSE ACCOUNT </th>
                                                <th width="10%">NOTES </th>

                                                <th width="15%">AMOUNT</th>
                                                <th width="4%" class="d-none">RATE</th>
                                                <th width="4%">Tax</th>
                                                <th width="4%">Tax Val</th>

                                                <th width="4%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="p-3">
                                                <td class="p-1 bg-light borde-1 border-light text-center"><input
                                                        class="case" type="checkbox" /></td>

                                                <td>

                                                    <select name="ItemID0[]" id="ItemID0_1"
                                                        class="item form-select form-control-sm select2   changesNoo "
                                                        onchange="km(this.value,1);" style="width: 300px !important;">
                                                        <option value="">select</option>
                                                        @foreach ($items as $key => $value)
                                                            <option value="{{ $value->ChartOfAccountID }}">
                                                                {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="ChartOfAccountID[]" id="ItemID_1">
                                                </td>


                                                <td>
                                                    <input type="text" name="Description[]" id="Description_1"
                                                        class=" form-control ">
                                                </td>
                                                <td>
                                                    <input type="number" name="Amount[]" id="Amount_1"
                                                        class="form-control changesNo amount-input" step="0.01"
                                                        autocomplete="off" onkeypress="return IsNumeric(event);"
                                                        ondrop="return false;" onpaste="return false;" value="0">
                                                </td>
                                                <td class="d-none">
                                                    <input type="number" name="Qty[]" id="Qty_1"
                                                        class=" form-control changesNo" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01" value="1">
                                                </td>

                                                <td class="d-none">
                                                    <input type="number" name="Price[]" id="Price_1"
                                                        class=" form-control changesNo" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01" value="1">
                                                </td>

                                                <td>
                                                    <select name="Tax[]" id="TaxID_1"
                                                        class="form-select changesNo tax exclusive_cal" required="">
                                                        <?php foreach ($tax as $key => $valueX1) : ?>
                                                        <option value="{{ $valueX1->TaxPer }}">
                                                            {{ $valueX1->Description }}</option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="TaxVal[]" id="TaxVal_1"
                                                        class=" form-control totalLinePrice2 tax" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01">
                                                </td>

                                                <td>
                                                    <input type="number" name="ItemTotal[]" id="ItemTotal_1"
                                                        class=" form-control totalLinePrice " autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01">
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-1 mb-2" style="margin-left: 29px;">
                                <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                    <button class="btn btn-danger delete" type="button"><i
                                            class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                    <button class="btn btn-success addmore" type="button"><i
                                            class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

                                </div>

                                <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                    <div id="result"></div>

                                </div>
                                <br>

                            </div>


                            <div class="row mt-4">

                                <div class="col-lg-8 col-12  ">


                                    <label for="" class="mt-2">Description</label>
                                    <textarea class="form-control" rows='5' name="DescriptionNotes" id="note"
                                        placeholder="Description notes if any."></textarea>

                                    <br>
                                    <iframe src="{{ URL('/Attachment') }}" width="100%" height="40%" border="0"
                                        scrolling="yes" style="overflow: hidden;"></iframe>

                                    <div class="mt-2"><button type="submit"
                                            class="btn btn-success w-md float-right">Save</button>
                                        <a href="{{ URL('/Expense') }}"
                                            class="btn btn-secondary w-md float-right">Cancel</a>

                                    </div>







                                </div>


                                <div class="col-lg-4 col-12 ">
                                    <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->
                                    <form class="form-inline">
                                        <div class="form-group mt-1">
                                            <label>Grand Total Tax: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" class="form-control" id="grandtotaltax"
                                                    name="grandtotaltax" placeholder="Subtotal"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Sub Total1: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" class="form-control" id="subTotal"
                                                    name="SubTotal" placeholder="Subtotal"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Discount: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>

                                                <input type="text" class="form-control" value="0"
                                                    id="discountper" name="DiscountPer" placeholder="Tax"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">

                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" name="DiscountAmount" class="form-control"
                                                    id="discountAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;" value="0">
                                            </div>
                                        </div>



                                        <div class="form-group mt-1 d-none">

                                            <label>Total: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Total" class="form-control" step="0.01"
                                                    id="totalafterdisc" readonly placeholder="Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Tax: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>

                                                <input type="text" class="form-control" id="taxpercentage"
                                                    name="Taxpercentage" placeholder="tax %"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">

                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" name="TaxpercentageAmount" class="form-control"
                                                    id="taxpercentageAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group mt-1 d-none">

                                            <label>Shipping: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Shipping" class="form-control"
                                                    step="0.01" id="shipping" placeholder="Grand Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group mt-1">

                                            <label>Grand Total: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Grandtotal" class="form-control"
                                                    step="0.01" id="grandtotal" placeholder="Grand Total" readonly
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">
                                            </div>
                                        </div>



                                        <div class="form-group mt-1 d-none">
                                            <label>Amount Paid: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control" id="amountPaid"
                                                    name="amountPaid" placeholder="Amount Paid"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group mt-1 d-none">

                                            <label>Amount Due: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control amountDue" name="amountDue"
                                                    id="amountDue" placeholder="Amount Due"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01">
                                            </div>
                                        </div>

                                </div>
                            </div>
                            <div>



                            </div>





                </form>

                <!--  <div class='row'>
                                          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class="well text-center">
                                          <h2>Back TO Tutorial: <a href="#"> Invoice System </a> </h2>
                                        </div>
                                          </div>
                                        </div>   -->



            </div>
        </div>
    </div>

    <script>
        var i = $('table tbody tr').length; // start counter

        // === MAIN CALCULATION LOGIC ===
        function calculateLine(rowId) {
            var amount = parseFloat($('#Amount_' + rowId).val()) || 0;
            var taxRate = parseFloat($('#TaxID_' + rowId).val()) || 0;
            var TaxType = $('#tax_type').val(); // 'inclusive' or 'exclusive'

            var taxAmount, lineTotal;

            if (TaxType === 'inclusive') {
                // Amount entered is inclusive of tax → calculate tax portion & exclusive total
                lineTotal = amount / (1 + taxRate / 100); // exclusive amount
                taxAmount = amount - lineTotal; // tax = inclusive - exclusive
            } else {
                // Exclusive: Amount is without tax
                taxAmount = amount * (taxRate / 100);
                lineTotal = amount + taxAmount;
            }

            $('#TaxVal_' + rowId).val(taxAmount.toFixed(2));
            $('#ItemTotal_' + rowId).val(lineTotal.toFixed(2));
        }

        function calculateAllLines() {
            $('table tbody tr').each(function() {
                var rowId = $(this).find('.amount-input').attr('id');
                if (rowId) {
                    rowId = rowId.split('_')[1];
                    calculateLine(rowId);
                }
            });
            updateGrandTotals();
        }

        function updateGrandTotals() {
            var totalTax = 0;
            var grandTotal = 0;

            $('.totalLinePrice2').each(function() { // TaxVal fields
                totalTax += parseFloat($(this).val()) || 0;
            });
            $('.totalLinePrice').each(function() { // ItemTotal fields
                grandTotal += parseFloat($(this).val()) || 0;
            });

            $('#grandtotaltax').val(totalTax.toFixed(2));
            $('#grandtotal').val(grandTotal.toFixed(2));
        }

        // === EVENT BINDINGS ===
        // When Expense Type changes → recalculate everything
        $(document).on('change', '#tax_type', function() {
            calculateAllLines();
        });

        // When Amount or Tax % changes in any row
        $(document).on('keyup change', '.amount-input, .tax-cal', function() {
            var rowId = $(this).attr('id').split('_')[1];
            calculateLine(rowId);
            updateGrandTotals();
        });

        // Add More Button – fixed & clean
        $(".addmore").on('click', function() {
            i++;
            var html = `
            <tr>
                <td class="text-center"><input class="case" type="checkbox"></td>
                <td>
                    <select name="ItemID0[]" id="ItemID0_${i}" class="form-select select2 changesNoo" style="width: 300px !important;" onchange="km(this.value,${i});">
                        <option value="">select</option>
                        @foreach ($items as $value)
                            <option value="{{ $value->ChartOfAccountID }}">{{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="ChartOfAccountID[]" id="ItemID_${i}">
                </td>
                <td><input type="text" name="Description[]" id="Description_${i}" class="form-control"></td>
                <td><input type="number" name="Amount[]" id="Amount_${i}" class="form-control amount-input" step="0.01" value="0"></td>
                <td class="d-none"><input type="number" name="Qty[]" id="Qty_${i}" value="1"></td>
                <td class="d-none"><input type="number" name="Price[]" id="Price_${i}" value="0"></td>
                <td>
                    <select name="Tax[]" id="TaxID_${i}" class="form-select tax-cal">
                        <?php foreach ($tax as $valueX1): ?>
                            <option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}</option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="TaxVal[]" id="TaxVal_${i}" class="form-control totalLinePrice2" step="0.01"></td>
                <td><input type="number" name="ItemTotal[]" id="ItemTotal_${i}" class="form-control totalLinePrice" step="0.01"></td>
            </tr>`;
            $('table tbody').append(html);
            $('#ItemID0_' + i).select2();
        });

        // Delete rows
        $(".delete").on('click', function() {
            $('.case:checked').parents('tr').remove();
            calculateAllLines();
        });

        // Optional: km function (if you still use it for something)
        function km(v, id) {
            $('#ItemID_' + id).val(v);
        }

        // Initialize on page load
        $(document).ready(function() {
            calculateAllLines();
        });
    </script>

    <script type="text/javascript">
        //<![CDATA[


        $(function() {
            $('#WalkinCustomer').hide();
            $('#PartyID').change(function() {

                if (this.options[this.selectedIndex].value == '1') {
                    // alert('dd');

                    $('#WalkinCustomer').show();
                    $('#1WalkinCustomerName').focus();

                } else {
                    $('#WalkinCustomer').hide();
                    $('#1WalkinCustomerName').val(0);
                }
            });
        });


        //]]>
    </script>
    <script type="text/javascript">
        //<![CDATA[


        $(function() {
            $('#paymentdetails').hide();
            $('#PaymentMode').change(function() {

                if (this.options[this.selectedIndex].value == 'Cheque') {
                    // alert('dd');

                    $('#paymentdetails').show();
                    $('#PaymentDetails').focus();

                } else {
                    $('#paymentdetails').hide();
                    $('#PaymentDetails').val('');
                }
            });
        });


        //]]>
    </script>

    <!-- ajax trigger -->
    <script>
        function ajax_balance(SupplierID) {

            // alert($("#csrf").val());

            $('#result').prepend('')
            $('#result').prepend(
                '<img id="theImg" src="{{ asset('assets / images / ajax.gif ') }}" />'
            )

            var SupplierID = SupplierID;

            // alert(SupplierID);
            if (SupplierID != "") {
                /*  $("#butsave").attr("disabled", "disabled"); */
                // alert(SupplierID);
                $.ajax({
                    url: "{{ URL('/Ajax_Balance') }}",
                    type: "POST",
                    data: {
                        _token: $("#csrf").val(),
                        SupplierID: SupplierID,

                    },
                    cache: false,
                    success: function(data) {



                        $('#result').html(data);



                    }
                });
            } else {
                alert('Please Select Branch');
            }
        }
    </script>

    <script>
        $("#InvoiceType").change(function() {

            // alert(p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu);

            var InvoiceType = $('#InvoiceType').val();

            // console.log(InvoiceType);
            if (InvoiceType != "") {
                /*  $("#butsave").attr("disabled", "disabled"); */
                // alert('next stage if else');
                // console.log(InvoiceType);

                $.ajax({

                    url: "{{ URL('/ajax_invoice_vhno') }}",
                    type: "POST",
                    data: {
                        // _token: p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu,
                        "_token": $("#csrf").val(),
                        InvoiceType: InvoiceType,

                    },
                    cache: false,

                    success: function(data) {

                        // alert(data.success);
                        $('#invoict_type').html(data);



                    }
                });
            }

        });
    </script>
    <script type="text/javascript">
        function GetSelectedTextValue(seletedVal) {
            gTotalVal = $('#grandtotal').val();
            if (gTotalVal) {


                var txt;
                if (confirm("Are you sure you want to update tax of complete invoice!")) {
                    txt = "You pressed OK!";

                    var TaxValue = seletedVal.value;

                    var table_lenght = $('table tr').length;
                    let discountamount = 0;


                    var grandsum = 0
                    var taxsum = 0;
                    for (let i = 1; i < table_lenght; i++) {
                        Qty = $('#Qty_' + i).val();
                        Price = $('#Price_' + i).val();


                        $('#TaxID_' + i).val(TaxValue);
                        disPerLine = parseFloat(Price) * (TaxValue / 100);
                        $('#TaxVal_' + i).val(parseFloat(disPerLine));

                        grandsum += (Qty * Price) + disPerLine;
                        taxsum += disPerLine;

                        $('#ItemTotal_' + i).val((Qty * Price) + disPerLine);

                    }
                    $('#grandtotaltax').val(parseFloat(taxsum));
                    // assigning subtotal value
                    $('#subTotal').val(parseFloat(grandsum));


                    // fetching discount percentage
                    var discountper = $('#discountper').val();
                    // calculating discount amount
                    discountamount = parseFloat(grandsum) * (parseFloat(discountper) / 100);
                    $('#discountAmount').val(parseFloat(discountamount));
                    //amount after discount
                    $('#totalafterdisc').val(parseFloat(grandsum) - parseFloat(discountamount));

                    // fetching percentage of tax
                    var taxper = $('#taxpercentage').val();
                    // calculating percentage amount
                    taxamount = parseFloat(grandsum) * (parseFloat(taxper) / 100);
                    $('#taxpercentageAmount').val(parseFloat(taxamount));

                    //calculating shiping cost
                    var shipping = $('#shipping').val();



                    var grandtotal = (parseFloat(grandsum) + parseFloat(taxamount) + parseFloat(shipping)) - parseFloat(
                        discountamount);
                    // Calculating grandtotal
                    $('#grandtotal').val(grandtotal);
                    // alert(discountamount);
                } else {
                    $('#seletedVal').val('select');
                }

            } else {
                return alert("Please create invoice first");
            }
        }
    </script>



    <!-- END: Content-->

@endsection
