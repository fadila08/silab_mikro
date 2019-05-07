<?php

namespace App\Transformers;

use App\User;
use App\Absensi;
use App\Kelas;
use League\Fractal\TransformerAbstract;


class ViewUserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'nama' => $user->nama,
            'nomor_induk' => $user->nomor_induk,
            'email' => $user->email,
            'nomor_whatsapp' => $user->nomor_whatsapp,
            'id' => $user->id
       ];
    }

}