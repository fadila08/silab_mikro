<?php

namespace App\Transformers;

use App\User;
use App\Galeri;
use League\Fractal\TransformerAbstract;


class GaleriTransformer extends TransformerAbstract
{
    public function transform(Galeri $galeri)
    {
        return [
            'id' => $galeri->id,
            'judul' => $galeri->judul,
            'gambar' => $galeri->gambar,
            'diupload pada' => $galeri->created_at->diffForHumans()
       ];
    }

}