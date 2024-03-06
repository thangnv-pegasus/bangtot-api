<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function showAll(){
        return response([
            'status' => 200,
            'message' => 'get all blog is success',
            'blogs' => DB::table('blogs')->get()
        ]);
    }

    public function getBlog($id){
        return 'this is blog id ' . $id;
    }

    public function newPost(Request $request){
        try{
            $validate = $request->validate([
                'title' => 'nullable',
                'content' => 'nullable',
                'imageUrl' => 'nullable',
                'publicId' => 'nullable'
            ]);

            $post = DB::table('blogs')->insert([
                'name' => $request->title,
                'idUser' => auth()->user()->id,
                'content' => $request->content,
                'image_publicId' => $request->publicId,
                'imageUrl' => $request->imageUrl
            ]);
            return response([
                'status' => 200,
                'message' => 'create new post is successed!',
                'post' => $post
            ]);
        }catch(Exception $e){
            return response([
                'status' => 200,
                'message' => 'please enter complete information!'
            ]);
        }
    }

    public function getAuthor(Request $request, $id){
        return response([
            'status' => 200,
            'message' => 'get author is successed',
            'author' => User::find($id)->name
        ]);
    }

}
