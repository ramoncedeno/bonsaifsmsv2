<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

     /**
     * Define the heads for the Excel file.
     */
    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Email',
            'Created At',
        ];
    }

    // Mape the columns within migration and assign the imported file
    public function map($user): array

    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('Y-m-d'),
        ];
    }

}
