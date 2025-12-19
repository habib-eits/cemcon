@extends('tmp')

@section('title', $pagetitle)


@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
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

                        <form action="{{ route('job-profit-loss-report') }}" class="row g-3 align-items-end">

                            <!-- Project / Job -->
                            <div class="col-auto">
                                <label class="form-label" for="JobID">Project / Job</label>
                                <select name="JobID" id="JobID" class="form-control select2">
                                    <option value="">All Projects</option>
                                    @foreach($jobs as $job)
                                        <option @selected(request()->JobID == $job->JobID ) value="{{ $job->JobID }}">
                                            {{ $job->JobNo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- From Date -->
                            <div class="col-auto">
                                <label class="form-label" for="fromDate">From Date</label>
                                <input type="date" name="fromDate" value="{{ old('fromDate',request()->fromDate)}}" class="form-control">
                            </div>

                            <!-- To Date -->
                            <div class="col-auto">
                                <label class="form-label" for="toDate">To Date</label>
                                <input type="date" name="toDate" value="{{ old('toDate',request()->toDate)}}" class="form-control">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>

                    <div class="row g-3 mb-4 mt-2">

                        <!-- Total Sales -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-uppercase">Total Sales</h6>
                                    <h3 class="fw-bold">
                                        {{ number_format($data['totalSales'], 2) }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Expenses -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 text-white">
                                <div class="card-body">
                                    <h6 class="text-uppercase">Total Expenses</h6>
                                    <h3 class="fw-bold">
                                        {{ number_format($data['totalExpenses'], 2) }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Profit / Loss -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 
                                {{ $data['profitLoss'] >= 0 ? 'text-warning' : 'text-warning' }} ">
                                <div class="card-body">
                                    <h6 class="text-uppercase">Profit / Loss</h6>
                                    <h3 class="fw-bold">
                                        {{ number_format($data['profitLoss'], 2) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                           <table class="table table-bordered table-hover table-sm text-wrap">
                            <thead class="table-dark">
                                <tr>
                                    {{-- <th>Expense ID</th> --}}
                                    <th>Date</th>
                                    <th>Expense No</th>
                                    <th>Job </th>
                                    <th>Supplier</th>
                                    <th>Reference No</th>
                                    {{-- <th>Tax Type</th> --}}
                                    <th>Tax</th>
                                    <th>Grand Total</th>
                            </thead>
                            <tbody>
                                @foreach($data['expenses'] as $expense)
                                <tr>
                                    {{-- <td>{{ $expense->ExpenseMasterID }}</td> --}}
                                    <td>{{ $expense->Date }}</td>
                                    <td>{{ $expense->ExpenseNo }}</td>
                                    <td>{{ $expense->JobNo }}</td>
                                    <td>{{ $expense->SupplierName }}</td>
                                    <td>{{ $expense->ReferenceNo ?? '-' }}</td>
                                    {{-- <td>{{ $expense->TaxType ?? '-' }}</td> --}}
                                    <td>{{ number_format($expense->Tax, 2) }}</td>
                                    <td>{{ number_format($expense->GrantTotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

  



@endsection
