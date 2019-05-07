<?php

namespace App\Imports;

use App\User;
use App\Kelas;
use App\Dosbim;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosbimImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
      $jsons = json_decode(file_get_contents('_config/config.json'));
      foreach ($rows as $row) 
      {
        $dosen = User::where([
          ['kode', '=', $row['kodedsn']]
        ])->first();

        $user = User::where('nomor_induk', '=', $row['nbi'])->first();

        $kelas = Kelas::where([
          ['kelas', '=', $row['kelas']],
          ['tahun_pelajaran', '=', $jsons->tahun_ajaran]
        ])->first();

        if ($user->count() > 0 && $dosen->count() > 0 && $kelas->count() > 0 && $row['kodedsn'] != '' && $row['kodedsn'] != null) {
          $dosbim = Dosbim::where([
            ['id_mhs', '=', $user->id],
            ['id_kelas', '=', $kelas->id]
          ])->first();
            // dd('sesat');
          $dosbim->update([
            'id_dosbim' => $dosen->id
          ]);
        }
      }
    }
}
