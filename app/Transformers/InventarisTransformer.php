<?php

namespace App\Transformers;

use App\User;
use App\Inventaris;
use League\Fractal\TransformerAbstract;


class InventarisTransformer extends TransformerAbstract
{
    public function transform(Inventaris $inventaris)
    {
        return [
            'id' => $inventaris->id,
            'nama_barang' => $inventaris->nama_barang,
            'jumlah' => $inventaris->jumlah,
            'kondisi' => $inventaris->kondisi,
            'diupload pada' => $inventaris->created_at->diffForHumans()
       ];
    }

}