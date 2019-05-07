<?php

namespace App\Transformers;

use App\User;
use App\Pengumuman;
use League\Fractal\TransformerAbstract;

class PengumumanTransformer extends TransformerAbstract
{
    public function transform(Pengumuman $pengumuman)
    {
        return [
            'id' => $pengumuman->id,
            'judul' => $pengumuman->judul,
            'batas_tanggal_berlaku' => $pengumuman->batas_tanggal_berlaku,
            'diupload pada' => $pengumuman->created_at->diffForHumans()
       ];
    }

}