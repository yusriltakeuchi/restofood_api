<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'nik' => $this->profile->nik,
            'tanggal_lahir' => $this->profile->tanggal_lahir,
            'alamat' => $this->profile->alamat,
            'jenis_kelamin' => $this->profile->jenis_kelamin,
            'kota' => $this->profile->kota,
            'path_photo' => url('/') . $this->profile->path_photo,
            'file_photo' => $this->profile->file_photo,
        ];
    }
}
