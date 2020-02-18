<?php

namespace App\Http\Controllers;

use App\FileManager;
use App\Http\Resources\UserResource;
use App\ResponseHandler;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    private $user;
    private $respHandler;
    private $fileManager;
    public function __construct()
    {
        $this->user = new User();
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string|email',
            'nama' => 'required|string',
            'nik' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|string',
            'image' => 'required',
            'jenis_kelamin' => 'required',
            'kota' => 'required'
        ]);

        //if validation failed then return back
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        //set all request to variable input
        $input = $request->all();
        
        //Check if users is not already registered
        if (!$this->user->where('username', $input['username'])->where('email', $input['email'])->first()) {
            //Encrypting password
            $input['password'] = Hash::make($input['password']);

            //Storing images
            $input['path_photo'] = $this->fileManager->saveData($request->file('image'), $input['username'], '/images/users/');
            $input['file_photo'] = $this->fileManager->fileResult;

            //Inserting data users
            $user = $this->user->create($input);
            $user->profile()->create($input);

            //We are except the password to response
            return $this->respHandler->send(201, "Successfully register account", new UserResource($user));
        } else {
            return $this->respHandler->exists("Users");
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required'
        ]);

        //if validation failed then return back
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        //set all request to variable input
        $input = $request->all();

        //Check if username exists;
        $user = $this->user->where('username', $input["username"])->first();
        if ($user) {
            
            //Checking password
            if (Hash::check($input['password'], $user->password)) {
                return $this->respHandler->send(200, "Berhasil login", new UserResource($user));
            } else {
                return $this->respHandler->badCredentials();
            }
        } else {
            return $this->respHandler->notFound("Users");
        }
    }
}
