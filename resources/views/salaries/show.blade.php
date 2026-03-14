@extends('salary')
@section('title', 'Salary Sheet')
@section('content')
    <style>
        .col-group-1 {
            background-color: #fde2e2 !important;
        }

        .col-group-2 {
            background-color: #e2f0fd !important;
        }

        .col-group-3 {
            background-color: #e2fde2 !important;
        }

        .col-group-4 {
            background-color: #fff9e2 !important;
        }

        .col-group-5 {
            background-color: #f2e2fd !important;
        }

        input[type="number"]:not(.no-style) {
            text-align: right;
            padding: 0px 2px 0px 0px;
            border-radius: 0;
        }

        input[type="number"][readonly]:not(.no-style) {
            border: none;
            background: none;
        }

        /* ── Employee link style ── */
        .employee-slip-link {
            color: #0d6efd;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 500;
            white-space: nowrap;
        }

        .employee-slip-link:hover {
            color: #0a58ca;
        }

        /* ── Salary Slip Modal ── */
        #salarySlipModal .modal-dialog {
            max-width: 820px;
        }

        #salarySlipModal .modal-body {
            padding: 0;
            height: 640px;
        }

        #salarySlipIframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* Loading overlay inside iframe area */
        #iframeLoader {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
    </style>

    <div class="main-content">
        <div class="page-content mt-2">
            <div class="container-fluid">
                <h3>Salary Sheet Details</h3>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <strong>Branch:</strong> {{ $salary->branch->BranchName ?? '-' }}
                    </div>
                    <div class="col-md-2">
                        <strong>Date:</strong> {{ $salary->salary_month }}
                    </div>
                    <div class="col-md-2">
                        <strong>Office Hours:</strong> {{ $salary->office_hours_per_day }}
                    </div>
                    <div class="col-md-2">
                        <strong>Working Days:</strong> {{ $salary->working_days }}
                    </div>
                    <div class="col-md-2">
                        <strong>OT Working Days Rate:</strong> {{ $salary->overtime_working_day_rate }}
                    </div>
                    <div class="col-md-2">
                        <strong>OT Holiday Rate:</strong> {{ $salary->overtime_holiday_rate }}
                    </div>
                </div>

                @foreach ($salaryTypes as $type)
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">{{ $type['name'] }}</div>
                        <div class="">
                            @if ($type['employees']->isEmpty())
                                <p class="text-center text-warning">No Employee</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm text-center align-middle">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="col-group-1"></th>
                                                <th colspan="3" class="col-group-2 text-center">Basic</th>
                                                <th colspan="3" class="col-group-3 text-center">OT Working Days</th>
                                                <th colspan="3" class="col-group-4 text-center">OT Holiday</th>
                                                <th colspan="3" class="col-group-5"></th>
                                            </tr>
                                            <tr>
                                                <th class="col-group-1" style="width: 4%">S#</th>
                                                <th class="col-group-1" style="width: 14%">Employee</th>
                                                <th class="col-group-1" style="width: 6%">Salary</th>
                                                <th class="col-group-1" style="width: 10%">Designation</th>

                                                <th class="col-group-2" style="width: 6%">Rate</th>
                                                <th class="col-group-2" style="width: 4%">Hrs</th>
                                                <th class="col-group-2" style="width: 6%">Amount</th>

                                                <th class="col-group-3" style="width: 6%">Rate</th>
                                                <th class="col-group-3" style="width: 4%">Hrs</th>
                                                <th class="col-group-3" style="width: 6%">Amount</th>

                                                <th class="col-group-4" style="width: 6%">Rate</th>
                                                <th class="col-group-4" style="width: 4%">Hrs</th>
                                                <th class="col-group-4" style="width: 6%">Amount</th>

                                                <th class="col-group-5" style="width: 6%">Gross</th>
                                                <th class="col-group-5" style="width: 5%">Adv</th>
                                                <th class="col-group-5" style="width: 7%">Net</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($type['employees'] as $row)
                                                <tr>
                                                    <td class="col-group-1">{{ $loop->iteration }}</td>

                                                    {{-- ✅ CHANGED: Employee name is now a clickable link --}}
                                                    <td class="col-group-1">
                                                        <a class="employee-slip-link" href="#"
                                                            data-slip-url="{{ route('salaries.slip', $row->id) }}"
                                                            data-employee-name="{{ $row->employee->FirstName ?? 'Employee' }}"
                                                            onclick="openSalarySlip(this); return false;">
                                                            {{ $row->employee->FirstName ?? 'N/A' }}
                                                        </a>
                                                    </td>

                                                    <td class="col-group-1">{{ $row->salary_base_amount }}</td>
                                                    <td class="col-group-1">{{ $row->jobTitle->JobTitleName ?? 'N/A' }}
                                                    </td>

                                                    {{-- Basic --}}
                                                    <td class="col-group-2 text-end">{{ $row->basic_hourly_rate }}</td>
                                                    <td class="col-group-2 text-end">{{ $row->basic_worked_hours }}</td>
                                                    <td class="col-group-2 text-end">{{ $row->basic_total }}</td>

                                                    {{-- OT --}}
                                                    <td class="col-group-3 text-end">{{ $row->overtime_hourly_rate }}</td>
                                                    <td class="col-group-3 text-end">{{ $row->overtime_hours }}</td>
                                                    <td class="col-group-3 text-end">{{ $row->overtime_total }}</td>

                                                    {{-- Holiday OT --}}
                                                    <td class="col-group-4 text-end">
                                                        {{ $row->holiday_overtime_hourly_rate }}</td>
                                                    <td class="col-group-4 text-end">{{ $row->holiday_overtime_hours }}
                                                    </td>
                                                    <td class="col-group-4 text-end">{{ $row->holiday_overtime_total }}
                                                    </td>

                                                    {{-- Totals --}}
                                                    <td class="col-group-5 text-end">{{ $row->gross_salary }}</td>
                                                    <td class="col-group-5 text-end">{{ $row->advance_paid }}</td>
                                                    <td class="col-group-5 text-end">{{ $row->net_salary }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>


    {{-- ============================================================ --}}
    {{-- SALARY SLIP MODAL WITH IFRAME                               --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="salarySlipModal" tabindex="-1" aria-labelledby="salarySlipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header py-2">
                    <h6 class="modal-title mb-0" id="salarySlipModalLabel">
                        <i class="bi bi-file-earmark-person me-1"></i>
                        Salary Slip — <span id="slipEmployeeName"></span>
                    </h6>
                    <div class="d-flex align-items-center gap-2 ms-auto me-2">
                        {{-- Print Button --}}
                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                            onclick="printSalarySlip()" title="Print Salary Slip (A4)">
                            <i class="bi bi-printer"></i>
                            Print
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body position-relative">
                    {{-- Loading spinner shown while iframe loads --}}
                    <div id="iframeLoader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <iframe id="salarySlipIframe" src="about:blank" title="Salary Slip" onload="onIframeLoad()">
                    </iframe>
                </div>

            </div>
        </div>
    </div>

    <script>
        /**
         * Opens the salary slip modal and loads the slip URL into the iframe.
         * Called from the employee name <a> tag.
         */
        function openSalarySlip(link) {
            const url = link.getAttribute('data-slip-url');
            const name = link.getAttribute('data-employee-name');

            // Set employee name in modal title
            document.getElementById('slipEmployeeName').textContent = name;

            // Show loader, clear old src
            document.getElementById('iframeLoader').style.display = 'flex';
            document.getElementById('salarySlipIframe').src = url;

            // Open Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('salarySlipModal'));
            modal.show();
        }

        /**
         * Hides the loading spinner once the iframe has finished loading.
         */
        function onIframeLoad() {
            const loader = document.getElementById('iframeLoader');
            const iframe = document.getElementById('salarySlipIframe');

            // Don't hide on blank src (initial state)
            if (iframe.src === 'about:blank' || iframe.src === window.location.href) return;

            loader.style.display = 'none';
        }

        /**
         * Triggers the browser print dialog scoped to the iframe content only.
         * The salary slip HTML already has @media print styles for A4.
         */
        function printSalarySlip() {
            const iframe = document.getElementById('salarySlipIframe');

            if (!iframe.contentWindow) {
                alert('Slip is still loading. Please wait a moment.');
                return;
            }

            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

        // Reset iframe src when modal is closed to stop any ongoing load
        document.getElementById('salarySlipModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('salarySlipIframe').src = 'about:blank';
            document.getElementById('iframeLoader').style.display = 'flex';
            document.getElementById('slipEmployeeName').textContent = '';
        });
    </script>

@endsection
