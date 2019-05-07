<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' =>$user->id,
            'username' =>$user->username,
            'nama' => $user->nama,
            'nomor_induk' => $user->nomor_induk,
            'email' => $user->email,
            'nomor_whatsapp' => $user->nomor_whatsapp,
            'id_roles' => $user->id_roles,
            // 'registered' => $user->created_at->diffForHumans(),
        ];
    }
}