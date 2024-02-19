<?php

namespace App\Http\Controllers;

use App\Models\Receip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReceipController extends Controller
{
    /**
     * get all receipes and filter by category
     * GET / api/receipes 
     * @param #category
     */
    public function index(){
        try{
            return Receip::filter([
                'category' => request(["category"])
            ])->with('category:id,name')->orderBy("created_at","desc")->paginate(6); //[]
        }catch(Exception $e){
            return response()->json(
                [
                    "message" => "This is system error.",
                    "status" => 500
                ],500
            );
        }
    }

     /**
     * get single receipes and filter by category
     * GET / api/receipes 
     * @param #category
     */
    public function show($id){
        try{
            $receipe = Receip::find($id);
            
            // throw error 
            if(!$receipe){
                return response()->json([
                        "message" => "Receipe Not Found",
                        "status" => 404
                    ],404);
            }
            return $receipe;

        }catch(Exception $e){
            return response()->json(
                [
                    "message" => "This is system error.",
                    "status" => 500
                ],500
            );
        }
    }

    /**
     * store a receip
     * POST - api/receipes
     */
    public function store(){
        try{
            // Validation start 
            $validator = Validator::make(request()->all() , [
                "title" => "required",
                "description" => "required",
                "category_id" => ["required",Rule::exists("categories","id")],
                "photo" => "required"
            ]);
            if($validator->fails()){

                $flatteredErrors = collect($validator->errors())->flatMap(function ($messages , $field){
                    return [$field => $messages[0]];
                } );
                return response()->json([
                    "message" => $flatteredErrors,
                    "status" => 400
                ],400);
            }
            $receipe = new Receip();
            $receipe->title = request("title");
            $receipe->description = request("description");
            $receipe->category_id = request("category_id");
            $receipe->photo = request("photo");
            $receipe->save();

            return response()->json($receipe,202);
        }catch(Exception $e){
            return response()->json([
                "message" => "this is system error",
                "status" => 500
            ],500);
        }
    }

    /**
     * update a receipe 
     * PATCH api/receipes/id
     */
    public function update($id){
        try{

            $receipe = Receip::find($id);
            if(!$receipe){
                return response()->json([
                    "message" => "receipe not found",
                    "status" => 404
                ],404);
            };

            // Validation start 
            $validator = Validator::make(request()->all() , [
                "title" => "required",
                "description" => "required",
                "category_id" => ["required",Rule::exists("categories","id")],
                "photo" => "required"
            ]);
            if($validator->fails()){

                $flatteredErrors = collect($validator->errors())->flatMap(function ($messages , $field){
                    return [$field => $messages[0]];
                } );
                return response()->json([
                    "message" => $flatteredErrors,
                    "status" => 400
                ],400);
            }
            
            $receipe->title = request("title");
            $receipe->description = request("description");
            $receipe->category_id = request("category_id");
            $receipe->photo = request("photo");
            $receipe->save();

            return response()->json($receipe,202);
        }catch(Exception $e){
            return response()->json([
                "message" => "this is system error",
                "status" => 500
            ],500);
        }
    }

    /**
     * upload a photo api 
     * POST /api/receipes/upload
     * @param photo
     */

    public function upload(){
        try{
            $validator = Validator::make(request()->all(),[
                "photo" => ["required","image"]
            ]);
            if($validator->fails()){
                return response()->json([
                    "message" => "Wrong data type",
                    "status" => 400
                ],400);
            }
            $path = request("photo")->store("/receipes");
            return response()->json([
                "path" => "http://localhost:8000/storage/".$path ,
                "status" => 200
            ],200);
        }catch(Exception $e){
            return response()->json([
                "message" => "this is system error",
                "status"=>500
            ],500);
        }
    }

    public function destory($id){
        try{
            $receipe = Receip::find($id);
            if(!$receipe){
                return response()->json([
                    "message" => "Receipe not found",
                    "status" => 404
                ],404);
            }
            $receipe->delete();
            return $receipe;
        }catch(Exception $e){
            return response()->json([
                "message"=>"This is system error",
                "status" => 500
            ],500);
        }
    }
}
