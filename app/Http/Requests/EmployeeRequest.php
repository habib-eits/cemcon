<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
       return [
            'BranchID'      => 'required',
            'FirstName'     => 'required',
            'DateOfBirth'   => 'required|date',
            'IsSupervisor'  => 'required|in:Yes,No',
            'StaffType'     => 'required',
            'StartDate'     => 'required|date',
            'picture'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ];
    }
    public function messages(): array
    {
        return [
            'BranchID.required'  => 'Branch is required',
            'FirstName.required' => 'First Name is required',
        ];
    }
}
