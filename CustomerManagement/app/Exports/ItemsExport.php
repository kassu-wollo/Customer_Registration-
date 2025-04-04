<?php

namespace App\Exports;
use App\Models\UserReg;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ItemsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserReg::select(['name','Phone','bdate','email'])->get();
    }
    public function headings(): array
    {
        return ['Name', 'PHONE','Birth Date','Email'];
    }

}
