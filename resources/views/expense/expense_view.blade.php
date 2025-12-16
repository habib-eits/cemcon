<!doctype html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Expense Detail</title>
 
</head>

<body>
    <div class="container my-4 p-4 border shadow-sm">
    <!-- Header: Logo + Company Details -->
    <div class="row align-items-center mb-4">
        <div class="col-md-4 text-center text-md-start">
            <img src="{{ asset('/documents/' . $company[0]->Logo) }}" alt="Company Logo" class="img-fluid" style="max-width:150px;">
        </div>
        <div class="col-md-8 text-center text-md-end">
            <h3 class="mb-1">{{ $company[0]->Name }}</h3>
            <div>TRN #: {{ $company[0]->TRN }}</div>
            <div>{{ $company[0]->Address }}</div>
            <div>{{ $company[0]->Contact }}</div>
            <div>{{ $company[0]->Email }}</div>
        </div>
    </div>

    <hr>

    <!-- Voucher Info -->
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Expense #: </strong> {{ $expense->ExpenseNo ?? '' }}<br>
            <strong>Date: </strong> {{ $expense->Date ?? date('Y-m-d') }}<br>
            <strong>Supplier: </strong> {{ $expense->SupplierName ?? '' }}
        </div>
        <div class="col-md-6 text-md-end">
            <strong>Paid Through: </strong> {{ $expense->ChartOfAccountName ?? '' }}<br>
            <strong>Reference #: </strong> {{ $expense->ReferenceNo ?? '' }}<br>
            <strong>Tax Type: </strong> {{ $expense->TaxType ?? 'exclusive' }}
        </div>
    </div>

    <!-- Expense Details Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>Expense Account</th>
                    <th>Notes</th>
                    <th>Amount</th>
                    <th>Tax %</th>
                    <th>Tax Value</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenseDetails as $detail)
                    <tr>
                        <td>{{ $detail->ChartOfAccountName ?? '' }}</td>
                        <td>{{ $detail->Notes }}</td>
                        <td>{{ number_format($detail->Amount, 2) }}</td>
                        <td>{{ $detail->TaxPer }}%</td>
                        <td>{{ number_format($detail->Tax, 2) }}</td>
                        <td>{{ number_format($detail->Total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="row justify-content-end mt-3">
        <div class="col-md-4">
            <table class="table table-borderless text-end">
                <tr>
                    <th>Total Before VAT:</th>
                    <td>{{ number_format($expense->Amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Tax Amount:</th>
                    <td>{{ number_format($expense->Tax, 2) }}</td>
                </tr>
                <tr class="fw-bold">
                    <th>Grand Total:</th>
                    <td>{{ number_format($expense->GrantTotal, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

    <!-- Footer / Signature -->
    <div class="row mt-5">
        <div class="col-md-6 text-center">
            _______________________<br>
            Prepared By
        </div>
        <div class="col-md-6 text-center">
            _______________________<br>
            Approved By
        </div>
    </div>
</div>

 <div style="height: 250px;">.</div>

        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>