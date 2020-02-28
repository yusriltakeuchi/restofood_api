<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\ResponseHandler;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;
    private $respHandler;
    public function __construct()
    {
        $this->user = new User();
        $this->respHandler = new ResponseHandler();
    }
    public function getProfile($id)
    {
        $user = $this->user->with('profile')->find($id);
        if ($user) {
            return $this->respHandler->send(200, "Berhasil mendapatkan profile", new UserResource($user));
        } else {
            return $this->respHandler->notFound("Akun");
        }
    }
}
