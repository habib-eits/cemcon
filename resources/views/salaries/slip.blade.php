<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $company->Name ?? 'Company' }} — Salary Slip</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
 
    body {
      background: #e8e8e8;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 30px 20px;
      font-family: 'Arial', sans-serif;
    }
 
    .slip-wrapper {
      background: white;
      width: 720px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
 
    /* ── HEADER ── */
    .header-box { border: 2px solid #333; }
 
    .header-top {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 16px 6px;
      border-bottom: 1px solid #999;
      gap: 14px;
    }
 
    .logo {
      width: 60px; height: 60px;
      border: 2px solid #333;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; background: white; overflow: hidden;
    }
    .logo img { width: 100%; height: 100%; object-fit: contain; }
    .logo-placeholder { font-size: 28px; line-height: 1; }
 
    .company-title { font-size: 22px; font-weight: 900; letter-spacing: 0.5px; color: #111; }
 
    .header-address {
      font-size: 11.5px; color: #333; text-align: center;
      padding: 5px 10px; border-bottom: 1px solid #999;
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }
 
    .header-bottom { display: flex; align-items: center; padding: 6px 12px; }
    .cemcon-brand  { font-size: 13px; font-weight: 700; color: #111; flex: 1; }
    .monthly-title { font-size: 14px; font-weight: 700; color: #111; flex: 1; text-align: center; }
 
    /* ── EMPLOYEE INFO ── */
    .info-table { width: 100%; border-collapse: collapse; margin-top: 14px; border: 2px solid #333; }
    .info-table td { padding: 7px 10px; font-size: 11.5px; border: 1px solid #999; color: #111; }
    .info-table td:nth-child(odd)  { font-weight: 600; width: 22%; background: #fafafa; }
    .info-table td:nth-child(even) { width: 28%; min-width: 120px; }
 
    /* ── MAIN TABLE ── */
    .main-table { width: 100%; border-collapse: collapse; margin-top: 14px; border: 2px solid #333; }
    .main-table th { background: #d4d4d4; padding: 8px 10px; font-size: 12px; font-weight: 700; text-align: center; border: 1px solid #999; color: #111; }
    .main-table th.left-header  { width: 50%; border-left: none; border-top: none; border-bottom: 2px solid #555; }
    .main-table th.right-header { width: 50%; border-right: none; border-top: none; border-bottom: 2px solid #555; }
    .main-table td { padding: 7px 10px; font-size: 11.5px; border: 1px solid #bbb; color: #111; }
    .main-table tr td:first-child { border-left: none; }
    .main-table tr td:last-child  { border-right: none; }
    .main-table .label-col { width: 34%; }
    .main-table .value-col { width: 16%; text-align: right; color: #444; }
    .main-table .divider-col { width: 2px; border-left: 2px solid #555 !important; border-right: 2px solid #555 !important; padding: 0; }
    .main-table tr:last-child td { border-bottom: none; font-weight: 700; }
 
    /* ── SIGNATURE ── */
    .sig-section { margin-top: 22px; }
    .sig-row { display: flex; justify-content: space-between; margin-bottom: 6px; }
    .sig-row span { font-size: 11.5px; color: #111; }
    .confirm-text { font-size: 10.5px; color: #333; margin: 10px 0 14px; line-height: 1.5; }
    .sig-row-bottom { display: flex; justify-content: space-between; margin-top: 4px; }
    .sig-row-bottom span { font-size: 11.5px; color: #111; }
 
    @media print {
      body { background: white; padding: 0; }
      .slip-wrapper { box-shadow: none; width: 100%; }
      @page { size: A4; margin: 15mm; }
    }
  </style>
</head>
<body>
<div class="slip-wrapper">
 
  <!-- HEADER -->
  <div class="header-box">
    <div class="header-top">
      <div class="logo">
        @if(!empty($company->Logo))
          <img src="{{ asset('documents/' . $company->Logo) }}" alt="{{ $company->Name }} Logo">
        @else
          <span class="logo-placeholder">⚙️</span>
        @endif
      </div>
      <div class="company-title">{{ strtoupper($company->Name ?? 'COMPANY NAME') }}</div>
    </div>
 
    <div class="header-address">
      {{ $company->Address ?? 'Company Address' }} :-
      <span>📞</span>
      Phone: {{ $company->Contact ?? 'N/A' }}
    </div>
 
    <div class="header-bottom">
      <span style="flex:1"></span>
      <span class="monthly-title">Monthly Salary Slip</span>
      <span style="flex:1"></span>
    </div>
  </div>
 
  <!-- EMPLOYEE INFO — populated from $detail -->
  <table class="info-table">
    <tr>
      <td>Employee Name</td>
      <td>{{ $detail->employee->FirstName ?? 'N/A' }} {{ $detail->employee->LastName ?? '' }}</td>
      <td>Designation</td>
      <td>{{ $detail->jobTitle->JobTitleName ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td>Employee ID</td>
      <td>{{ $detail->employee->id ?? 'N/A' }}</td>
      <td>Month of Salary</td>
      <td>{{ $detail->salary->salary_month ?? 'N/A' }}</td>
    </tr>
  </table>
 
  <!-- INCOME / DEDUCTIONS — populated from $detail -->
  <table class="main-table">
    <thead>
      <tr>
        <th class="left-header"  colspan="2">Income (AED)</th>
        <th class="divider-col"></th>
        <th class="right-header" colspan="2">Deductions (AED)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="label-col">Basic Salary</td>
        <td class="value-col">{{ number_format($detail->basic_total ?? 0, 2) }}</td>
        <td class="divider-col"></td>
        <td class="label-col">Advance</td>
        <td class="value-col">{{ $detail->advance_paid ? number_format($detail->advance_paid, 2) : '-' }}</td>
      </tr>
      <tr>
        <td class="label-col">Food Allowance</td>
        <td class="value-col">-</td>
        <td class="divider-col"></td>
        <td class="label-col">Loan</td>
        <td class="value-col">-</td>
      </tr>
      <tr>
        <td class="label-col">OT Working Days</td>
        <td class="value-col">{{ $detail->overtime_total ? number_format($detail->overtime_total, 2) : '-' }}</td>
        <td class="divider-col"></td>
        <td class="label-col">Absent / Not Present</td>
        <td class="value-col">-</td>
      </tr>
      <tr>
        <td class="label-col">OT Holiday</td>
        <td class="value-col">{{ $detail->holiday_overtime_total ? number_format($detail->holiday_overtime_total, 2) : '-' }}</td>
        <td class="divider-col"></td>
        <td class="label-col">Other Deduction</td>
        <td class="value-col">-</td>
      </tr>
      <tr>
        <td class="label-col">Gross Salary</td>
        <td class="value-col">{{ number_format($detail->gross_salary ?? 0, 2) }}</td>
        <td class="divider-col"></td>
        <td class="label-col"><strong>Net Salary (AED)</strong></td>
        <td class="value-col"><strong>{{ number_format($detail->net_salary ?? 0, 2) }}</strong></td>
      </tr>
    </tbody>
  </table>
 
  <!-- SIGNATURES -->
  <div class="sig-section">
    <div class="sig-row">
      <span>Sign of Employee___________________</span>
      <span>Manager________________________________</span>
    </div>
    <p class="confirm-text">
      I confirm that my salary has been received in full and that all dues are settled up to date,
      with no outstanding balance due.
    </p>
    <div class="sig-row-bottom">
      <span>Accounts____________________</span>
      <span>Approved by____________________</span>
    </div>
  </div>
 
</div>
</body>
</html>