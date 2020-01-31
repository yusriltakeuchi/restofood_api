<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    protected $table = 'foods';
    protected $fillable = [
        'title', 'description', 'full_description',
        'price', 'image'
    ];

    public function isExists($title) {
        $data = $this->where('title', $title)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function isExistsById($id) {
        $data = $this->find($id);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
