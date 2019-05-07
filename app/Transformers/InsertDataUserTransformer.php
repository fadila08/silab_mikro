<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;
// use App\Roles;

class InsertDataUserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'username'    =>$user->username,
            'nama' => $user->nama,
            'nomor_induk' => $user->nomor_induk,
            'email' => $user->email,
            'nomor_whatsapp' => $user->nomor_whatsapp,
            'id_roles' => $user->id_roles,
            'success' => 'Data berhasil ditambahkan',
        ];
    }
}