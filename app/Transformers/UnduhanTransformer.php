<?php

namespace App\Transformers;

use App\User;
use App\Unduhan;
use League\Fractal\TransformerAbstract;

class UnduhanTransformer extends TransformerAbstract
{
    public function transform(Unduhan $unduhan)
    {
        return [
            'id' => $unduhan->id,
            'judul' => $unduhan->judul,
            'keterangan' => $unduhan->keterangan,
            'file' => $unduhan->file,
            'batas_tanggal_berlaku' => $unduhan->batas_tanggal_berlaku,
            'diupload pada' => $unduhan->created_at->diffForHumans()
       ];
    }

}