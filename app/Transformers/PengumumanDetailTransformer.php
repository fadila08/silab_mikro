<?php

namespace App\Transformers;

use App\User;
use App\Pengumuman;
use League\Fractal\TransformerAbstract;

class PengumumanDetailTransformer extends TransformerAbstract
{
    public function transform(Pengumuman $pengumuman)
    {
        return [
            'id' => $pengumuman->id,
            'judul' => $pengumuman->judul,
            'isi' => $pengumuman->isi,
            'file_lampiran' => $pengumuman->file_lampiran,
            'batas_tanggal_berlaku' => $pengumuman->batas_tanggal_berlaku,
            'diupload pada' => $pengumuman->created_at->diffForHumans()
       ];
    }

}