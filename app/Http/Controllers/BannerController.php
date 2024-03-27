<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BannerController extends Controller
{
    public function store()
    {
        return response([
            'status' => 200,
            'message' => 'get banner is successed',
            'banner' => DB::table('banner')->get()
        ]);
    }

    public function create(Request $request)
    {

        try {
            foreach ($request->file as $key => $image) {
                DB::table('banner')->insert([
                    'name' => $image['publicId'],
                    'public_id' => $image['publicId'],
                    'url' => $image['url'],
                ]);
            }
            return response([
                'status' => 200,
                'message' => 'create banner is successed',
                'banner' => DB::table('banner')->get()
            ]);
        } catch (Throwable $e) {
            return response([
                'status' => 201,
                'message' => 'create banner is failed',
                'error' => $e,
            ]);
        }
    }

    public function delete(Request $request,$id)
    {
        try {
            DB::table('banner')->where('id', '=', $id)->delete();

            return response([
                'status' => 200,
                'message' => 'delete banner is successed',
                'banner' => DB::table('banner')->get()
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'delete banner is failed',
                'error' => $e
            ]);
        }
    }
}