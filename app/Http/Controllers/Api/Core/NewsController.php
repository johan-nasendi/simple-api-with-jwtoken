<?php

namespace App\Http\Controllers\Api\Core;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Core\Categories;
use App\Helpers\ResponseFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Core\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function getsNews()
    {
        $user = JWTAuth::user();
        $data = News::with('category','user')
        ->orderBy('id','desc')
        ->where('author',$user->id)
        ->get();
        return response()->json([
            'error' => false,
            'status' => true,
            'message' => 'News data successfully found',
            'data' => $data
        ], 200);
    }

    public function getNews($id)
    {
        $user = JWTAuth::user();
        $data = News::where('author',$user->id)
        ->find($id);
        if ($data!=null) {
            return ResponseFormatter::responseSuccessWithData('News data successfully found!', $data);
        }else{
            return ResponseFormatter::responseError("Data Not Found!", 404);
        }
    }

    public function postNews(Request $request){
        $user = JWTAuth::user();
        $validation = Validator::make($request->all(), [
            'slug' => 'unique:news,slug',
            'title' => 'required',
            'desc' => 'required',
            'category_id' => 'required',
            'brief_desc' => 'required',
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
                'category_id' => $request->category_id,
                'author' => $user->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'desc' => $request->desc,
                'brief_desc' => $request->brief_desc,
            ];
            $data = News::create($data);
            return ResponseFormatter::responseCreated('News data created successfully!', $data);
           } catch (\Throwable $th) {
            return ResponseFormatter::responseError($th->getMessage(), 400);
           }
        }
    }
    
    public function updateNews(Request $request,$id){
        $user = JWTAuth::user();
        $validation = Validator::make($request->all(), [
            'slug' => 'unique:news,slug,'.$id,
            'title' => 'required',
            'desc' => 'required',
            'category_id' => 'required',
            'brief_desc' => 'required',
            
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

            $data = News::find($id);
            if ($data!=null) {
                $data->author = $user->id;
                $data->category_id = $request->category_id;
                $data->title = $request->title;
                $data->slug = Str::upper($request->title);
                $data->desc = $request->desc;
                $data->brief_desc = $request->brief_desc;
                $data->status = $request->status;
                $data->update();
                return ResponseFormatter::responseCreated('News data updated successfully!', $data);
            } else {
                return ResponseFormatter::responseError("Data Not Found!", 404);
            }
           } catch (\Throwable $th) {
            return ResponseFormatter::responseError($th->getMessage(), 400);
           }
        }
    }

    public function deleteNews($id){
        $user = JWTAuth::user();
        $data = News::where('author',$user->id)->find($id);
        if ($data!=null) {
            $data->delete();
            return ResponseFormatter::responseSuccessWithData('News data deleted successfully!', $data);
        }else{
            return ResponseFormatter::responseError("Data Not Found!", 404);
        }
    }
}
