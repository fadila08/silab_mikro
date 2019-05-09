<?php

namespace App\Transformers;

use App\User;
use App\Roles;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'nama' => $user->nama,
            'nomor_induk' => $user->nomor_induk,
            'email' => $user->email,
            'nomor_whatsapp' => $user->nomor_whatsapp,
            'role' => [
                'id' => $user->id_roles,
                'nama_role' => Roles::find($user->id_roles)->nama_role
            ]
        ];
    }
}