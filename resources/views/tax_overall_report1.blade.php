@extends('template.tmp')

@section('title', $pagetitle)

@section('content')

{{-- ================= STYLES ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- ================= ALERTS ================= --}}
            @if (session('error'))
                <div class="alert alert-{{ session('class') }} p-2">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger p-2">
                    <strong>There were some problems with your input:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================= VAT ON SALES ================= --}}
            @php
                $salesSubTotal = $output_vat->sum('SubTotal');
                $salesTax = $output_vat->sum('Tax');
                $salesGrandTotal = $output_vat->sum('GrandTotal');
            @endphp

            <h5 class="mb-3">VAT on Sales</h5>

            <div class="table-responsive">
                <table id="vatSalesTable" class="table table-bordered table-striped table-sm align-middle w-100">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Date</th>
                            <th>Invoice #</th>
                            <th>Ref #</th>
                            <th>Customer / Supplier</th>
                            <th>Subtotal</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($output_vat as $row)
                            <tr class="{{ $row->PartyID }}">
                                <td class="text-start">{{ dateformatman($row->Date) }}</td>
                                <td class="text-start">{{ $row->InvoiceNo }}</td>
                                <td class="text-start">{{ $row->ReferenceNo }}</td>
                                <td>{{ $row->PartyID ? $row->PartyName : $row->SupplierName }}</td>
                                <td class="text-end">{{ number_format($row->SubTotal, 2) }}</td>
                                <td class="text-end">{{ number_format($row->Tax, 2) }}</td>
                                <td class="text-end">{{ number_format($row->GrandTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold table-light">
                        <tr>
                            <td colspan="4" class="text-end">Total</td>
                            <td class="text-center">{{ number_format($salesSubTotal, 2) }}</td>
                            <td class="text-end">
                                <span class="badge bg-info me-1">A1</span>
                                {{ number_format($salesTax, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($salesGrandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- ================= VAT ON EXPENSES ================= --}}
            @php
                $inputSubTotal = $input_vat->sum('SubTotal') + $expense_vat->sum('Amount');
                $inputTax = $input_vat->sum('Tax') + $expense_vat->sum('Tax');
                $inputGrandTotal = $input_vat->sum('GrandTotal') + $expense_vat->sum('Amount');
            @endphp

            <h5 class="mt-4">VAT on Expenses</h5>

            <div class="table-responsive">
                <table id="vatExpenseTable" class="table table-bordered table-striped table-sm align-middle w-100">
                    <thead class="table-danger text-center">
                        <tr>
                            <th>Date</th>
                            <th>Invoice #</th>
                            <th>Ref / Account</th>
                            <th>Supplier</th>
                            <th>Subtotal</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($input_vat as $row)
                            <tr class="{{ $row->PartyID }}">
                                <td class="text-start">{{ dateformatman($row->Date) }}</td>
                                <td class="text-start">{{ $row->InvoiceNo }}</td>
                                <td class="text-start">{{ $row->ReferenceNo }}</td>
                                <td>{{ $row->PartyID ? $row->PartyName : $row->SupplierName }}</td>
                                <td class="text-end">{{ number_format($row->SubTotal, 2) }}</td>
                                <td class="text-end">{{ number_format($row->Tax, 2) }}</td>
                                <td class="text-end">{{ number_format($row->GrandTotal, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach ($expense_vat as $row)
                            <tr class="">
                                <td class="text-start">{{ dateformatman($row->Date) }}</td>
                                <td class="text-start">{{ $row->ExpenseNo }}</td>
                                <td class="text-start">{{ $row->ChartOfAccountName }}</td>
                                <td>{{ $row->SupplierName }}</td>
                                <td class="text-end">{{ number_format($row->Amount, 2) }}</td>
                                <td class="text-end">{{ number_format($row->Tax, 2) }}</td>
                                <td class="text-end">{{ number_format($row->Amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold table-light">
                        <tr>
                            <td colspan="4" class="text-end">Total</td>
                            <td class="text-center">{{ number_format($inputSubTotal, 2) }}</td>
                            <td class="text-end">
                                <span class="badge bg-info me-1">A2</span>
                                {{ number_format($inputTax, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($inputGrandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function () {

    function initDataTable(id, title) {
        $(id).DataTable({
            paging: false,        // ❌ Disable pagination
            info: false,          // ❌ Hide "Showing X of Y"
            lengthChange: false,  // ❌ Remove page length dropdown
            ordering: true,
            searching: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: title,
                    className: 'btn btn-success btn-sm'
                }
            ],
            order: [[0, 'desc']]
        });
    }

    initDataTable('#vatSalesTable', 'VAT on Sales');
    initDataTable('#vatExpenseTable', 'VAT on Expenses');

});
</script>


@endsection
