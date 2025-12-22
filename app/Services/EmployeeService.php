<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeService
{
    /**
     * Handle file upload for employee picture
     */
    public function handleUpload(?Request $request, string $fieldName = 'employee_photo'): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $file = $request->file($fieldName);
        $filename = time() . '.' . $file->extension();
        $file->move(public_path('/emp-picture'), $filename);

        return $filename;
    }

    /**
     * Format date from d/m/Y or similar to Y-m-d for database
     */
    public function formatDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
    }

    /**
     * Prepare employee data for insert or update
     */
    public function prepareData(array $validated, ?string $picture = null): array
    {
        unset($validated['employee_photo']);

        return array_merge($validated, [
            'Picture'        => $picture,
            'DateOfBirth'    => $this->formatDate($validated['DateOfBirth'] ?? null),
            'StartDate'      => $this->formatDate($validated['StartDate'] ?? null),
            'VisaIssueDate'  => $this->formatDate($validated['VisaIssueDate'] ?? null),
            'VisaExpiryDate' => $this->formatDate($validated['VisaExpiryDate'] ?? null),
            'PassportExpiry' => $this->formatDate($validated['PassportExpiry'] ?? null),
            'EidExpiry'      => $this->formatDate($validated['EidExpiry'] ?? null),
        ]);
    }

    /**
     * Create a new employee
     */
    public function create(array $data): bool
    {
        return DB::table('employee')->insert($data);
    }

    /**
     * Update an existing employee
     */
    public function update(int $id, array $data): bool
    {
        return DB::table('employee')->where('EmployeeID', $id)->update($data);
    }

    /**
     * Get employee by ID
     */
    public function find(int $id)
    {
        return DB::table('employee')->where('EmployeeID', $id)->first();
    }
}
