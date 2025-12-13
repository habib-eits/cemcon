@extends('tmp')
@section('title', $pagetitle)

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- multiple image upload -->
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <form action="{{ URL('/ExpenseUpdate') }}" method="post" class="custom-validation">

                    <input type="hidden" name="ExpenseMasterID" value="{{ $expense_master[0]->ExpenseMasterID }}">
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
                                            <select name="SupplierID" id="SupplierID" class="form-select select2 mt-5" required="">
                                                <option value="">Select</option>
                                                <?php foreach ($supplier as $key => $value) : ?>
                                                    <option value="{{ $value->SupplierID }}" {{ $value->SupplierID == $expense_master[0]->SupplierID ? 'selected' : '' }}>
                                                        {{ $value->SupplierName }}
                                                    </option>
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
                                                    <option value="{{ $value->JobID }}" {{ $value->JobID == $expense_master[0]->JobID ? 'selected' : '' }}>
                                                        {{ $value->JobNo }}
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-1 row d-none" id="WalkinCustomer">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">or Walkin Customer</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="WalkinCustomerName" value="" placeholder="Walkin customer" id="1WalkinCustomerName">
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Paid Through </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="ChartOfAccountID_From" id="ChartOfAccountID_From"
                                                    class="form-select form-control-sm select2" style="width: 100% !important;" required="">
                                                <option value="">select</option>
                                                @foreach ($chartofaccount as $key => $value)
                                                    <option value="{{ $value->ChartOfAccountID }}" {{ $value->ChartOfAccountID == $expense_master[0]->ChartOfAccountID ? 'selected' : '' }}>
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
                                                <input type="text" name="ReferenceNo" autocomplete="off" class="form-control"
                                                       value="{{ $expense_master[0]->ReferenceNo }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tax Type Dropdown -->
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger">Tax Type</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="TaxType" id="tax_type" class="form-select">
                                                    <option value="exclusive" {{ $expense_master[0]->TaxType == 'exclusive' ? 'selected' : '' }}>Exclusive</option>
                                                    <option value="inclusive" {{ $expense_master[0]->TaxType == 'inclusive' ? 'selected' : '' }}>Inclusive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Expense #</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="ExpenseNo" autocomplete="off" class="form-control"
                                                       value="{{ $expense_master[0]->ExpenseNo }}" readonly>
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
                                                    <input type="text" name="Date" autocomplete="off" class="form-control"
                                                           placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd"
                                                           data-date-container="#datepicker21" data-provide="datepicker"
                                                           data-date-autoclose="true"
                                                           value="{{ $expense_master[0]->Date }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr class="invoice-spacing">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table>
                                        <thead>
                                            <tr class="bg-light borde-1 border-light" style="height: 40px;">
                                                <th width="2%" class="text-center"><input id="check_all" type="checkbox" /></th>
                                                <th width="1%">EXPENSE ACCOUNT</th>
                                                <th width="10%">NOTES</th>
                                                <th width="15%">AMOUNT</th>
                                                <th width="4%" class="d-none">RATE</th>
                                                <th width="4%">Tax</th>
                                                <th width="4%">Tax Val</th>
                                                <th width="4%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expense_detail as $key => $value1)
                                                <?php $no = $key + 1; ?>
                                                <tr class="p-3">
                                                    <td class="p-1 bg-light borde-1 border-light text-center"><input class="case" type="checkbox" /></td>
                                                    <td>
                                                        <select name="ItemID0[]" id="ItemID0_{{ $no }}"
                                                                class="item form-select form-control-sm select2 changesNoo"
                                                                onchange="km(this.value, {{ $no }});" style="width: 300px !important;">
                                                            <option value="">select</option>
                                                            @foreach ($chartofaccount as $value)
                                                                <option value="{{ $value->ChartOfAccountID }}" {{ $value->ChartOfAccountID == $value1->ChartOfAccountID ? 'selected' : '' }}>
                                                                    {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="ChartOfAccountID[]" id="ItemID_{{ $no }}" value="{{ $value1->ChartOfAccountID }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="Description[]" id="Description_{{ $no }}" class="form-control" value="{{ $value1->Notes }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="Amount[]" id="Amount_{{ $no }}"
                                                               class="form-control changesNo amount-input" step="0.01"
                                                               value="{{ $value1->Amount }}">
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="number" name="Qty[]" id="Qty_{{ $no }}" value="1">
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="number" name="Price[]" id="Price_{{ $no }}" value="0">
                                                    </td>
                                                    <td>
                                                        <select name="Tax[]" id="TaxID_{{ $no }}" class="form-select changesNo tax-cal">
                                                            <?php foreach ($tax as $valueX1) : ?>
                                                                <option value="{{ $valueX1->TaxPer }}" {{ $valueX1->TaxPer == $value1->TaxPer ? 'selected' : '' }}>
                                                                    {{ $valueX1->Description }}
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="TaxVal[]" id="TaxVal_{{ $no }}"
                                                               class="form-control totalLinePrice2" step="0.01"
                                                               value="{{ $value1->Tax }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="ItemTotal[]" id="ItemTotal_{{ $no }}"
                                                               class="form-control totalLinePrice" step="0.01"
                                                               value="{{ $value1->Amount + $value1->Tax }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-1 mb-2" style="margin-left: 29px;">
                                <div class="col-xs-5 col-sm-3 col-md-3 col-lg-3">
                                    <button class="btn btn-danger delete" type="button"><i class="bx bx-trash align-middle font-medium-3 me-25"></i> Delete</button>
                                    <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>
                                </div>
                                <div class="col-xs-5 col-sm-3 col-md-3 col-lg-3">
                                    <div id="result"></div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-8 col-12">
                                    <label for="" class="mt-2">Description</label>
                                    <textarea class="form-control" rows="5" name="DescriptionNotes" id="note" placeholder="Description notes if any.">{{ $expense_master[0]->DescriptionNotes ?? '' }}</textarea>

                                    <br>
                                    <iframe src="{{ URL('/Attachment') }}" width="100%" height="40%" border="0" scrolling="yes" style="overflow: hidden;"></iframe>

                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-success w-md float-right">Save</button>
                                        <a href="{{ URL('/Expense') }}" class="btn btn-secondary w-md float-right">Cancel</a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-12">
                                    <div class="form-group mt-1">
                                        <label>Grand Total Tax: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                            <input type="text" class="form-control" id="grandtotaltax" name="grandtotaltax"
                                                   value="{{ $expense_master[0]->Tax }}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1">
                                        <label>Grand Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                            <input type="number" name="Grandtotal" class="form-control" step="0.01"
                                                   id="grandtotal" readonly value="{{ $expense_master[0]->GrantTotal }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var i = $('table tbody tr').length;

        // === MAIN CALCULATION LOGIC ===
        function calculateLine(rowId) {
            var amount = parseFloat($('#Amount_' + rowId).val()) || 0;
            var taxRate = parseFloat($('#TaxID_' + rowId).val()) || 0;
            var TaxType = $('#tax_type').val(); // 'inclusive' or 'exclusive'

            var taxAmount, lineTotal;

            if (TaxType === 'inclusive') {
                // Amount entered is inclusive of tax
                lineTotal = amount / (1 + taxRate / 100); // exclusive base
                taxAmount = amount - lineTotal;
            } else {
                // Exclusive
                taxAmount = amount * (taxRate / 100);
                lineTotal = amount + taxAmount;
            }

            $('#TaxVal_' + rowId).val(taxAmount.toFixed(2));
            $('#ItemTotal_' + rowId).val(lineTotal.toFixed(2));
        }

        function calculateAllLines() {
            $('table tbody tr').each(function () {
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

            $('.totalLinePrice2').each(function () { // TaxVal
                totalTax += parseFloat($(this).val()) || 0;
            });
            $('.totalLinePrice').each(function () { // ItemTotal
                grandTotal += parseFloat($(this).val()) || 0;
            });

            $('#grandtotaltax').val(totalTax.toFixed(2));
            $('#grandtotal').val(grandTotal.toFixed(2));
        }

        // === EVENT BINDINGS ===
        $(document).on('change', '#tax_type', function () {
            calculateAllLines();
        });

        $(document).on('keyup change', '.amount-input, .tax-cal', function () {
            var rowId = $(this).attr('id').split('_')[1];
            calculateLine(rowId);
            updateGrandTotals();
        });

        // Add More Button
        $(".addmore").on('click', function () {
            i++;
            var html = `
                <tr>
                    <td class="text-center"><input class="case" type="checkbox"></td>
                    <td>
                        <select name="ItemID0[]" id="ItemID0_${i}" class="form-select select2 changesNoo" style="width: 300px !important;" onchange="km(this.value,${i});">
                            <option value="">select</option>
                            @foreach ($chartofaccount as $value)
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
        $(".delete").on('click', function () {
            $('.case:checked').parents('tr').remove();
            calculateAllLines();
        });

        // Hidden ChartOfAccountID copy
        function km(v, id) {
            $('#ItemID_' + id).val(v);
        }

        // Initialize Select2 on existing rows
        $(document).ready(function () {
            $('.select2').select2();
            calculateAllLines(); // Recalculate on load to ensure correct values (especially for inclusive)
        });
    </script>
@endsection