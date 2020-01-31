<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Foods;
use App\ResponseHandler;
use App\FileManager;
use App\Http\Resources\FoodResource;
use Illuminate\Support\Facades\Validator;

class FoodsController extends Controller
{
    private $foods;
    private $respHandler;
    private $fileManager;
    public function __construct() {
        $this->foods = new Foods();
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = $this->foods->get();
        if ($foods->count() > 0) {
            return $this->respHandler->send(200, "Successfully get foods", FoodResource::collection($foods));
        } else {
            return $this->respHandler->notFound("Foods");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'full_description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();
        if (!$this->foods->isExists($request->title)) {
            //Store new data
            $path = $this->fileManager
                    ->saveData($request->file('image'), $request->title, '/images/');

            $input['image'] = $path;
            $createData = $this->foods->create($input);
            if ($createData) {
                return $this->respHandler->send(200, "Successfully create foods", new FoodResource($createData));
            } else {
                return $this->respHandler->internalError();
            }

        } else {
            return $this->respHandler->exists("Foods");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->foods->isExistsById($id)) {
            $food = $this->foods->find($id);
            return $this->respHandler->send(200, "Successfully get food", new FoodResource($food));
        } else {
            return $this->respHandler->notFound("Foods");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'full_description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();
        if ($this->foods->isExistsById($id)) {
            $foods = $this->foods->find($id);
            $this->fileManager->removeData($foods->image);

            //Store new data
            $path = $this->fileManager
                    ->saveData($request->file('image'), $request->title, '/images/');

            $input['image'] = $path;
            $updateData = $foods->update($input);

            if ($updateData) {
                return $this->respHandler->send(200, "Successfully update foods");
            } else {
                return $this->respHandler->internalError();
            }
        } else {
            return $this->respHandler->notFound("Foods");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->foods->isExistsById($id)) {
            $food = $this->foods->find($id);
            $food->delete();
            return $this->respHandler->send(200, "Successfully delete food");
        } else {
            return $this->respHandler->notFound("Foods");
        }
    }
}
