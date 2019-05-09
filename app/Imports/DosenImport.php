<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $jsons = json_decode(file_get_contents('_config/config.json'));
        foreach ($rows as $row) 
        {
          $user = User::create([
            'username' => $row['nbi'],
            'password' => bcrypt($row['nbi']),
            'nama' => ucwords(strtolower($row['nama'])),
            'nomor_induk' => $row['nbi'],
            'id_roles' => 4
          ]);
        }
    }
}
