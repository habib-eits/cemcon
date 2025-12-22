<?php

namespace App\Services;

use Illuminate\Http\Request;


class EmployeeService {


    public function uploadPicture(Request $request): ?string
    {
        if (!$request->hasFile('picture')) {
            return null;
        }

        $file = $request->file('picture');
        $filename = time() . '.' . $file->extension();
        $file->move(public_path('/emp-picture'), $filename);

        return $filename;
    }

    public function prepareEmployeeData(Request $request, ?string $pictureFile): array
    {
        return [
            'BranchID'              => $request->BranchID,
            'Title'                 => $request->Title,
            'IsSupervisor'          => $request->IsSupervisor,
            'FirstName'             => $request->FirstName,
            'MiddleName'            => $request->MiddleName,
            'LastName'              => $request->LastName,
            'DateOfBirth'           => $request->DateOfBirth,
            'Gender'                => $request->Gender,
            'Email'                 => $request->Email,
            'Nationality'           => $request->Nationality,
            'MobileNo'              => $request->MobileNo,
            'HomePhone'             => $request->HomePhone,
            'FullAddress'           => $request->FullAddress,
            'EducationLevel'        => $request->EducationLevel,
            'LastDegree'            => $request->LastDegree,
            'MaritalStatus'         => $request->MaritalStatus,
            'SSNorGID'              => $request->SSNorGID,
            'SpouseName'            => $request->SpouseName,
            'SpouseEmployer'        => $request->SpouseEmployer,
            'SpouseWorkPhone'       => $request->SpouseWorkPhone,
            'VisaIssueDate'         => $request->VisaIssueDate,
            'VisaExpiryDate'        => $request->VisaExpiryDate,
            'PassportNo'            => $request->PassportNo,
            'PassportExpiry'        => $request->PassportExpiry,
            'EidNo'                 => $request->EidNo,
            'EidExpiry'             => $request->EidExpiry,
            'NextofKinName'         => $request->NextofKinName,
            'NextofKinAddress'      => $request->NextofKinAddress,
            'NextofKinPhone'        => $request->NextofKinPhone,
            'NextofKinRelationship' => $request->NextofKinRelationship,
            'JobTitleID'            => $request->JobTitleID,
            'DepartmentID'          => $request->DepartmentID,
            'SupervisorID'          => $request->SupervisorID,
            'WorkLocation'          => $request->WorkLocation,
            'EmailOffical'          => $request->EmailOffical,
            'WorkPhone'             => $request->WorkPhone,
            'StartDate'             => $request->StartDate,
            'Salary'                => $request->Salary,
            'ExtraComission'        => $request->ExtraComission,
            'SalaryRemarks'         => $request->SalaryRemarks,
            'StaffType'             => $request->StaffType,
            'SalaryTypeID'          => $request->SalaryTypeID,
            'BankName'              => $request->BankName,
            'IBAN'                  => $request->IBAN,
            'AccountTitle'          => $request->AccountTitle,
            'Picture'               => $pictureFile,
        ];
    }

}