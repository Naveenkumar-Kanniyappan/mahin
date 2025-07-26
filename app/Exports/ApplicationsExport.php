<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Application::select([
            'application_no',
            'date',
            'location',
            'name',
            'father_name',
            'address',
            'mobile',
            'gmail',
            'aadhar',
            'pan',
            'bank_account_no',
            'ifsc',
            'education',
            'experience',
            'apply_job',
            'photo_path',
            'created_at',
            'updated_at'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Application No',
            'Date',
            'Location',
            'Name',
            'Father Name',
            'Address',
            'Mobile',
            'Email',
            'Aadhar',
            'PAN',
            'Bank Account',
            'IFSC',
            'Education',
            'Experience',
            'Applied Position',
            'Photo Path',
            'Created At',
            'Updated At'
        ];
    }
}