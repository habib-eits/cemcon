<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can add role check here later if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee');

        return [
            'BranchID'       => 'required|integer',
            'FirstName'      => 'required|string|max:255',
            'DateOfBirth'    => 'required|date',
            'IsSupervisor'   => 'required|in:Yes,No',
            'StaffType'      => 'required|string',
            'Email'          => [
                'required',
                'email',
                Rule::unique('employee', 'Email')->ignore($employeeId, 'EmployeeID'),
            ],
            'StartDate'      => 'required|date',
            'employee_photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',

            // Optional fields
            'Title'                  => 'nullable|string',
            'MiddleName'             => 'nullable|string',
            'LastName'               => 'nullable|string',
            'Gender'                 => 'nullable|string',
            'Nationality'            => 'nullable|string',
            'MobileNo'               => 'nullable|string',
            'HomePhone'              => 'nullable|string',
            'FullAddress'            => 'nullable|string',
            'EducationLevel'         => 'nullable|string',
            'LastDegree'             => 'nullable|string',
            'MaritalStatus'          => 'nullable|string',
            'SSNorGID'               => 'nullable|string',
            'SpouseName'             => 'nullable|string',
            'SpouseEmployer'         => 'nullable|string',
            'SpouseWorkPhone'        => 'nullable|string',
            'VisaIssueDate'          => 'nullable|date',
            'VisaExpiryDate'         => 'nullable|date',
            'PassportNo'             => 'nullable|string',
            'PassportExpiry'         => 'nullable|date',
            'EidNo'                  => 'nullable|string',
            'EidExpiry'              => 'nullable|date',
            'NextofKinName'          => 'nullable|string',
            'NextofKinAddress'       => 'nullable|string',
            'NextofKinPhone'         => 'nullable|string',
            'NextofKinRelationship'  => 'nullable|string',
            'JobTitleID'             => 'nullable|integer',
            'DepartmentID'           => 'nullable|integer',
            'SupervisorID'           => 'nullable|integer',
            'WorkLocation'           => 'nullable|string',
            'EmailOffical'           => 'nullable|email',
            'WorkPhone'              => 'nullable|string',
            'Salary'                 => 'nullable|numeric',
            'ExtraComission'         => 'nullable|numeric',
            'SalaryRemarks'          => 'nullable|string',
            'SalaryTypeID'           => 'nullable|integer',
            'BankName'               => 'nullable|string',
            'IBAN'                   => 'nullable|string',
            'AccountTitle'           => 'nullable|string',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'BranchID.required'   => 'Branch is required',
            'FirstName.required'  => 'First Name is required',
            'Email.required'      => 'Email is required',
            'Email.email'         => 'Please enter a valid email',
            'Email.unique'        => 'This email is already taken',
            'employee_photo.image'    => 'Profile picture must be an image',
            'employee_photo.max'      => 'Image size cannot exceed 20MB',
        ];
    }
}
