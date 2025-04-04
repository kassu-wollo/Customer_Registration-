<?php
namespace App\Imports;
use App\Models\UserReg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class UsersImport implements ToModel,WithStartRow
{public function startRow(): int
    {
        return 2; // Start reading from row 2 (skip the header row)
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $col)
    {
        return new UserReg([
            'name' => $col[0], // Adjust indexes based on your file columns
            'phone' => $col[1],
            'bdate' => $col[2],
            'email' => $col[3]
        ]);
    }
}
