@extends('tmp')
@section('title', $pagetitle)

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <script src="{{ asset('assets/invoice/js/jquery-1.11.2.min.js') }}"></script>
                <script src="{{ asset('assets/invoice/js/jquery-ui.min.js') }}"></script>
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
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Tax type</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="TaxType" id="TaxType"
                                                class="form-select form-control-sm select2   "
                                                style="width: 100% !important;" required="">
                                                <option value="">select</option>
                                                <option value="Inclusive">Inclusive</option>
                                                <option value="Exclusive">Exclusive</option>
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
                                                <th width="4%">Amount </th>
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
                                                <td >
                                                    <input type="number" name="BaseAmount[]" id="BaseAmount_1"
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
            </div>
        </div>
    </div>




    <script>
    $('input[name=tax_action]').change(function(e) {
        $('.exclusive_cal').val(e.target.value);
    });

    var i = $('table tr').length;

    $(".addmore").on('click', function() {
        html = '<tr class="border-1 border-light">';
        html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
        html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '" style="width: 300px !important;" class="form-select select2 changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{ $value->ChartOfAccountID }}|{{ $value->ChartOfAccountName }}">{{ $value->ChartOfAccountName }}</option>@endforeach</select><input type="hidden" name="ChartOfAccountID[]" id="ItemID_' + i + '"></td>';
        html += '<td><input type="text" name="Description[]" id="Description_' + i + '" class="form-control"></td>';
        html += '<td class="d-none"><input type="text" name="BaseAmount[]" id="BaseAmount_' + i + '" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';
        html += '<td><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';
        html += '<td><select name="Tax[]" id="TaxID_' + i + '" class="form-select changesNo exclusive_cal"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}</option><?php endforeach ?></select></td>';
        html += '<td><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class="form-control totalLinePrice2 tax" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';
        html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
        html += '</tr>';

        $('table').append(html);
        $('.select2', 'table').select2();
        i++;
    });

    // check all checkboxes
    $(document).on('change', '#check_all', function() {
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

    // delete selected rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculateTotal();
    });

    function km(v, id) {
        var val = $('#ItemID0_' + id).val().split("|");
        $('#ItemID_' + id).val(val[0]);

        calculateTotal();
        if (isNaN($('#discountAmount').val())) {
            $('#discountAmount').val(0);
        }
        calculatediscount();
        calculateTotal();
    }

    $(document).on(' keyup blur select', '.changesNoo123', function() {
        var id = $(this).attr('id').split("_")[1];
        var data = <?php echo $item; ?>;

        var item_idd = $('#ItemID_' + id).val();
        var json = data.find(item => item.ItemID == parseInt(item_idd));

        $('#BaseAmount_' + id).val(1);
        $('#Price_' + id).val(json["SellingPrice"]);
        calculateRowTotal(id);
        calculatediscount();
        calculateTotal();
    });

    function calculateRowTotal(id) {
        var Qty = parseFloat($('#BaseAmount_' + id).val()) || 1;
        var Price = parseFloat($('#Price_' + id).val()) || 0;
        var TaxPer = parseFloat($('#TaxID_' + id).val()) || 0;

        var TaxTypeVal = $('#TaxType').val(); // Inclusive / Exclusive
        var TotalPrice = Qty * Price;
        var TaxValue = 0;
        var ItemTotal = 0;

       if (TaxTypeVal === "Inclusive") {
            TaxValue = TotalPrice * TaxPer / (100 + TaxPer);
            ItemTotal = TotalPrice - TaxValue;  // Base amount (without VAT)
        } else {
            TaxValue = TotalPrice * TaxPer / 100;
            ItemTotal = TotalPrice + TaxValue;
        }

        $('#TaxVal_' + id).val(TaxValue.toFixed(2));
        $('#ItemTotal_' + id).val(ItemTotal.toFixed(2));

        calculateTotal();
    }

    // trigger row total on Qty, Price, Tax change
    $(document).on('change keyup blur', '.changesNo', function() {
        var id = $(this).attr('id').split("_")[1];
        calculateRowTotal(id);
    });

    $(document).on('change', '.changesNoo', function() {
        var id = $(this).attr('id').split("_")[1];
        var val = $('#ItemID0_' + id).val().split("|");
        $('#ItemID_' + id).val(val[0]);
        calculatediscount();
    });

    function calculatediscount() {
        var subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });
        subTotal = parseFloat($('#subTotal').val());

        var discountper = $('#discountper').val();
        if (discountper != '' && typeof(discountper) != "undefined") {
            var discountamount = parseFloat(subTotal) * (parseFloat(discountper) / 100);
            $('#discountAmount').val(parseFloat(discountamount.toFixed(2)));
            var total = subTotal - discountamount;
            $('#totalafterdisc').val(total.toFixed(2));
        } else {
            $('#discountper').val(0);
            $('#discountAmount').val(0);
            $('#totalafterdisc').val(subTotal.toFixed(2));
        }
    }

    $(document).on('blur', '#discountAmount', function() {
        calculatediscountper();
    });

    function calculatediscountper() {
        var subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });
        subTotal = parseFloat($('#subTotal').val());

        var discountAmount = $('#discountAmount').val();
        if (discountAmount != '' && typeof(discountAmount) != "undefined") {
            var discountper = (parseFloat(discountAmount) / parseFloat(subTotal)) * 100;
            $('#discountper').val(parseFloat(discountper.toFixed(2)));
            var total = subTotal - discountAmount;
            $('#totalafterdisc').val(total.toFixed(2));
        } else {
            $('#discountper').val(0);
            $('#totalafterdisc').val(subTotal.toFixed(2));
        }
    }

    $(document).on('change keyup blur', '#discountper', function() {
        calculatediscount();
        calculateTotal();
    });

    $(document).on('change keyup blur', '#taxpercentage', function() {
        calculateTotal();
    });

    $(document).on('change keyup blur', '#shipping', function() {
        calculateTotal();
    });

    function calculateTotal() {
        var subTotal = 0;
        var totalTax = 0;
        var grandTotal = 0;

        $(".totalLinePrice").each(function() {
            if ($(this).val() !== '') {
                subTotal += parseFloat($(this).val());
            }
        });

        $(".totalLinePrice2").each(function() {
            if ($(this).val() !== '') {
                totalTax += parseFloat($(this).val());
            }
        });

        var TaxTypeVal = $('#TaxType').val(); // Inclusive / Exclusive

        if (TaxTypeVal === "Inclusive") {
            // In this case subTotal = Net Amount
            // Grand Total = Net amount + VAT
            grandTotal = subTotal + totalTax;
        } else {
            // Exclusive case: ItemTotal already includes VAT
            grandTotal = subTotal;
        }

        $("#grandtotaltax").val(totalTax.toFixed(2));
        $("#subTotal").val(subTotal.toFixed(2));
        $("#grandtotal").val(grandTotal.toFixed(2));
    }


    $(document).on('change keyup blur', '#amountPaid', function() {
        calculateAmountDue();
    });

    function calculateAmountDue() {
        var amountPaid = parseFloat($('#amountPaid').val()) || 0;
        var total = parseFloat($('#grandtotal').val()) || 0;
        var amountDue = total - amountPaid;
        $('.amountDue').val(amountDue.toFixed(2));
    }

    var specialKeys = [8, 46]; // Backspace, Delete
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        return ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    }

    $(function() {
        $.fn.datepicker.defaults.format = "dd-mm-yyyy";
        $('#invoiceDate').datepicker({
            startDate: '-3d',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true
        });
    });

    $(function() {
        $('#WalkinCustomer').hide();
        $('#PartyID').change(function() {
            if (this.value == '1') {
                $('#WalkinCustomer').show();
                $('#1WalkinCustomerName').focus();
            } else {
                $('#WalkinCustomer').hide();
                $('#1WalkinCustomerName').val(0);
            }
        });
    });

    $(function() {
        $('#paymentdetails').hide();
        $('#PaymentMode').change(function() {
            if (this.value == 'Cheque') {
                $('#paymentdetails').show();
                $('#PaymentDetails').focus();
            } else {
                $('#paymentdetails').hide();
                $('#PaymentDetails').val('');
            }
        });
    });

    function ajax_balance(SupplierID) {
        if (!SupplierID) return alert('Please Select Branch');

        $.ajax({
            url: "{{ URL('/Ajax_Balance') }}",
            type: "POST",
            data: {_token: $("#csrf").val(), SupplierID: SupplierID},
            cache: false,
            success: function(data) {
                $('#result').html(data);
            }
        });
    }

    $("#InvoiceType").change(function() {
        var InvoiceType = $('#InvoiceType').val();
        if (!InvoiceType) return;

        $.ajax({
            url: "{{ URL('/ajax_invoice_vhno') }}",
            type: "POST",
            data: {_token: $("#csrf").val(), InvoiceType: InvoiceType},
            cache: false,
            success: function(data) {
                $('#invoict_type').html(data);
            }
        });
    });

    function GetSelectedTextValue(seletedVal) {
        var gTotalVal = parseFloat($('#grandtotal').val());
        if (!gTotalVal) return alert("Please create invoice first");

        if (confirm("Are you sure you want to update tax of complete invoice!")) {
            var TaxValue = seletedVal.value;
            var table_lenght = $('table tr').length;
            var grandsum = 0;
            var taxsum = 0;

            for (let i = 1; i < table_lenght; i++) {
                var Qty = parseFloat($('#BaseAmount_' + i).val()) || 0;
                var Price = parseFloat($('#Price_' + i).val()) || 0;

                $('#TaxID_' + i).val(TaxValue);
                var disPerLine = (Price * TaxValue / 100);
                $('#TaxVal_' + i).val(disPerLine.toFixed(2));
                $('#ItemTotal_' + i).val((Qty * Price + disPerLine).toFixed(2));

                grandsum += (Qty * Price + disPerLine);
                taxsum += disPerLine;
            }

            $('#grandtotaltax').val(taxsum.toFixed(2));
            $('#subTotal').val(grandsum.toFixed(2));

            var discountper = parseFloat($('#discountper').val()) || 0;
            var discountamount = grandsum * (discountper / 100);
            $('#discountAmount').val(discountamount.toFixed(2));
            $('#totalafterdisc').val((grandsum - discountamount).toFixed(2));

            var taxper = parseFloat($('#taxpercentage').val()) || 0;
            var taxamount = grandsum * (taxper / 100);
            $('#taxpercentageAmount').val(taxamount.toFixed(2));

            var shipping = parseFloat($('#shipping').val()) || 0;
            var grandtotal = (grandsum + taxamount + shipping - discountamount);
            $('#grandtotal').val(grandtotal.toFixed(2));
        } else {
            $('#seletedVal').val('select');
        }
    }
    $('#TaxType').on('change', function () {
        recalcAllRows();
    });

    function recalcAllRows() {
        $('input[name="BaseAmount[]"]').each(function () {
            var id = $(this).attr('id').split("_")[1];
            calculateRowTotal(id);
        });
    }


</script>

@endsection
