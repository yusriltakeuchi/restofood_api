<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Str;

class FileManager extends Model
{
    private $slug;
    public $fileResult;
    public function __construct()
    {
        $this->slug = new Slugify();
    }
    public function saveData($file, $title ,$path) {
        //upload file images
        $filePath = public_path() . $path;
        $fileName = $this->slug->slugify($title) . '-' . Str::random(10) .'.png';

        $file->move($filePath, $fileName);
        $this->fileResult = $fileName;
        return $path . $fileName;
    }

    public function removeData($path) {
        $filePath = public_path() . $path;
        unlink($filePath);
    }
}
