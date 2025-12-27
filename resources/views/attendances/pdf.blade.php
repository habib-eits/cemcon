<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 16px;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 6px 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
            text-align: left;
        }

        td.text-end {
            text-align: right;
        }

        .text-warning {
            color: #f39c12;
        }

        .text-danger {
            color: #e74c3c;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
        
        .page-break {
            page-break-after: always;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Attendance Report</h1>

    @foreach($salaryTypes as $type)
        <h2>{{ $type['name'] }}</h2>
        <table>
            <thead>
                <tr>
                    <th>S#</th>
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th class="text-end">Worked Hrs</th>
                    <th class="text-end">OT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($type['employees'] as $row)
                    @php
                        [$class, $status] = match($row->status){
                            '1' => ['','P'],
                            '0.5' => ['text-warning','H'],
                            default => ['text-danger', 'A']
                        };
                    @endphp
                    <tr class="{{ $class }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->employee->FirstName ?? 'N/A' }}</td>
                        <td>{{ $row->employee->jobTitle->JobTitleName ?? 'N/A' }}</td>
                        <td>{{ $row->job->JobNo ?? 'N/A' }}</td>
                        <td>{{ $status }}</td>
                        <td class="text-end">{{ $row->worked_hours ?? 0 }}</td>
                        <td class="text-end">{{ $row->over_time ?? 0 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- <div class="page-break"></div> <!-- New page for each salary type --> --}}
    @endforeach

    <div class="footer">
        Generated on: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>
</body>
</html>
