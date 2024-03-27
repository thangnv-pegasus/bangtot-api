<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneController extends Controller
{
    public function getAll()
    {
        return response([
            'status' => 200,
            'message' => 'get all hotline of page success',
            'phones' => DB::table('phone')->limit(3)->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = DB::table('phone')->where('id', '=', $id)->update([
                'name' => $request->name,
                'phoneNumber' => $request->phoneNumber
            ]);
            return response([
                'status' => 200,
                'message' => 'update phone is successed',
                'phone' => DB::table('phone')->where('id', '=', $id)->first(),
                'hotline' => DB::table('phone')->limit(3)->get()
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'update phone failed',
                'error' => $e
            ]);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $delete = DB::table('phone')->where('id', '=', $id)->delete();
            return response([
                'status' => 200,
                'message' => 'delete phone number is successed',
                'hotline' => DB::table('phone')->limit(3)->get(),
                'check' => $id
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'delete phone number failed'
            ]);
        }
    }
}