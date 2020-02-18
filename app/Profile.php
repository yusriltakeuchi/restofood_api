<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    protected $fillable = [
        'nama', 'nik', 'tanggal_lahir', 'alamat',
        'path_photo', 'file_photo', 'jenis_kelamin',
        'kota'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
