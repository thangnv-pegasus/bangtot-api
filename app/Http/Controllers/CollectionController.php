<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::table('collections')->insert([
                'name' => $request->name
            ]);
            return response([
                'status' => 200,
                'message' => 'create collection is successed',
                'collections' => DB::table('collections')->get()
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'create collection is failed',
                'error' => $e
            ]);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::table('collections')->where('id', '=', $id)->delete();
            return response([
                'status' => 200,
                'message' => 'delete collection is successed',
                'collections' => DB::table('collections')->get(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'delete collection is failed',
                'error' => $e
            ]);
        }
    }
}