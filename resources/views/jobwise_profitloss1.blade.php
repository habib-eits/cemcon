@extends('template.tmp')

@section('title', $pagetitle)

@section('content')

<div class="main-content">
<div class="page-content">
<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Job Wise Profit & Loss</h4>
                <div class="text-end">
                    @if(request()->StartDate && request()->EndDate)
                        From {{ request()->StartDate }} TO {{ request()->EndDate }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('error'))
        <div class="alert alert-{{ session('class') }} p-1">
            {{ session('error') }}
        </div>
    @endif

    <!-- SUMMARY CARD -->
    <div class="card mb-4">
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead>
                    <tr class="bg-light">
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><strong>Total Sales</strong></td>
                        <td class="text-end">
                            {{ number_format($sales ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Total Expenses</strong></td>
                        <td class="text-end">
                            {{ number_format($expenses ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr class="bg-light">
                        <td><strong>Profit / Loss</strong></td>
                        <td class="text-end">
                            <strong>{{ number_format($profitLoss ?? 0, 2) }}</strong>
                        </td>
                    </tr>

                </tbody>
            </table>

            @if($jobId)
                <div class="mt-2">
                    <strong>Job ID:</strong> {{ $jobId }}
                </div>
            @endif

        </div>
    </div>

    <!-- EXPENSE DETAILS -->
    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">Expense Details</h5>

            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th>Expense No</th>
                        <th>Reference No</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($expensesData ?? [] as $expense)
                        <tr>
                            <td>{{ $expense->ExpenseNo }}</td>
                            <td>{{ $expense->ReferenceNo }}</td>
                            <td class="text-end">
                                {{ number_format($expense->GrantTotal, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No expenses found</td>
                        </tr>
                    @endforelse

                    <tr class="bg-light">
                        <td colspan="2"><strong>Total Expenses</strong></td>
                        <td class="text-end">
                            <strong>{{ number_format($expenses ?? 0, 2) }}</strong>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>

</div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('body').addClass('sidebar-enable vertical-collpsed');
    });
</script>

@endsection
