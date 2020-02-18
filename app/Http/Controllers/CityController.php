<?php

namespace App\Http\Controllers;

use App\City;
use App\ResponseHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $city;
    private $respHandler;
    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
        $this->city = new City();
    }

    public function index()
    {
        $city = $this->city->get();
        if ($city->count() > 0) {
            return $this->respHandler->send(200, "Successfully get city", $city);
        } else {
            return $this->respHandler->notFound("City");
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        //if validation failed then return back
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();
        //Check if city not exists
        if (!$this->city->where('name', $input['name'])->first()) {
            $city = $this->city->create($input);
            if ($city) {
                return $this->respHandler->send(201, "City successfully created");
            } else {
                return $this->respHandler->internalError();
            }
        } else {
            return $this->respHandler->exists("City");
        }
    }

    public function delete($id)
    {
        $city = $this->city->find($id);
        if ($city) {
            $city->delete();
            return $this->respHandler->send(200, "Successfully delete city");
        } else {
            return $this->respHandler->notFound("City");
        }
    }
}
