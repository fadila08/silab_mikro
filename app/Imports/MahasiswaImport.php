<?php

namespace App\Imports;

use App\User;
use App\Absensi;
use App\Kelas;
use App\Dosbim;
use App\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $jsons = json_decode(file_get_contents('_config/config.json'));
        foreach ($rows as $row) 
        {
          $kelas = Kelas::where([
            ['kelas', '=', $row['kelas']],
            ['tahun_pelajaran', '=', $jsons->tahun_ajaran]
          ]);

          if (User::where('username', '=', $row['nbi'])->count() <= 0 && $kelas->count() > 0) {
            $user = User::create([
              'username' => $row['nbi'],
              'password' => bcrypt($row['nbi']),
              'nama' => ucwords(strtolower($row['nama'])),
              'nomor_induk' => $row['nbi'],
              'id_roles' => 5
            ]);
            $kelas = $kelas->first();
            Absensi::create([
              'id_mhs' => $user->id,
              'id_kelas' => $kelas->id
            ]);
            Dosbim::create([
              'id_mhs' => $user->id,
              'id_kelas' => $kelas->id
            ]);
            Nilai::create([
              'id_mhs' => $user->id,
              'id_kelas' => $kelas->id
            ]);
          } 
        }
    }
}
