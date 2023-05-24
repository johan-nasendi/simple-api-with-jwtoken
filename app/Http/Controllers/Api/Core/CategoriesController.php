<?php

namespace App\Http\Controllers\Api\Core;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Core\Categories;
use App\Helpers\ResponseFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function getsCategory()
    {
        $user = JWTAuth::user();
        $data = Categories::with('user')
        ->orderBy('id','desc')
        ->where('author',$user->id)
        ->get();
        return response()->json([
            'error' => false,
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data
        ], 200);
    }

    public function getCategory($id)
    {
        $user = JWTAuth::user();
        $data = Categories::where('id',$user->id)
        ->find($id);
        if ($data!=null) {
            return ResponseFormatter::responseSuccessWithData('Category data successfully found!', $data);
        }else{
            return ResponseFormatter::responseError("Data Not Found!", 404);
        }
    }

    public function postCategory(Request $request){
        $user = JWTAuth::user();
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => true,
                'status' => false,
                'message' => $validation->errors()->first(),
                'data' => $validation->errors()
            ],400);
        } else {
           try {
            $data = [
                'author' => $user->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ];
            $data = Categories::create($data);
            return ResponseFormatter::responseCreated('Category data created successfully!', $data);
           } catch (\Throwable $th) {
            return ResponseFormatter::responseError($th->getMessage(), 400);
           }
        }
    }
    
    public function updateCategory(Request $request,$id){
        $user = JWTAuth::user();
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$id,
            
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => true,
                'status' => false,
                'message' => $validation->errors()->first(),
                'data' => $validation->errors()
            ],400);
        } else {
           try {

            $data = Categories::find($id);
            if ($data!=null) {
                $data->author = $user->id;
                $data->name = $request->name;
                $data->slug = Str::upper($request->name);
                $data->update();
                return ResponseFormatter::responseCreated('Category data updated successfully!', $data);
            } else {
                return ResponseFormatter::responseError("Data Not Found!", 404);
            }
           } catch (\Throwable $th) {
            return ResponseFormatter::responseError($th->getMessage(), 400);
           }
        }
    }

    public function deleteCategory($id){
        $user = JWTAuth::user();
        $data = Categories::where('author',$user->id)->find($id);
        if ($data!=null) {
            $data->delete();
            return ResponseFormatter::responseSuccessWithData('Category data deleted successfully!', $data);
        }else{
            return ResponseFormatter::responseError("ata Not Found!", 404);
        }
    }

}
