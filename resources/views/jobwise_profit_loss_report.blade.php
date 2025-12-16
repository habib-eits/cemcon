@extends('template.tmp')
@section('title', $pageTitle)
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Jobwise Profit & Loss</h4>
                            <strong class="text-end"></strong>
                            From {{ request()->StartDate }} TO {{ request()->EndDate }}
                        </div>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">

                        {{ Session::get('error') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div>
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

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>
                                                    {{ $invoice->InvoiceNo }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($invoice->Date)->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    {{ $invoice->Total }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <td>

                                        </td>
                                        <td>
                                            <strong>Grand TOTAL</strong>
                                        </td>
                                        <td>
                                            {{ $invoices->sum('Total') }}
                                        </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">

                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-light">
                                            <td class="col-md-2">
                                                Expense No
                                            </td>
                                            <td class="col-md-6">
                                                Date
                                            </td>
                                            <td class="col-md-2">
                                                Total
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td>
                                                    {{ $expense->ExpenseNo }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($expense->Date)->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    {{ $expense->GrantTotal }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td>

                                            </td>
                                            <td>
                                                <strong>Grand Total</strong>
                                            </td>
                                            <td>
                                                {{ $expenses->sum('GrantTotal') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm">
                                        <tr class="bg-light">
                                            <td width="50%"><strong>TOTAL INCOME</strong></td>
                                            <td width="50%" class="text-end">
                                                {{ $invoices->sum('Total') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td><strong>TOTAL EXPENSE</strong></td>
                                            <td class="text-end">
                                                {{ $expenses->sum('GrantTotal') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td><strong>PROFIT & LOSS</strong></td>
                                            <td class="text-end">
                                                {{ $profitLoss }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- END: Content-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>



    <script>
        $(document).ready(function() {

            $('body').addClass('sidebar-enable vertical-collpsed')
            // $('body').removeClass('sidebar-enable vertical-collpsed')
            setTimeout(function() {
                $("body").removeClass("sidebar-enable vertical-collpsed");
            }, 5000);
        });
    </script>

@endsection
