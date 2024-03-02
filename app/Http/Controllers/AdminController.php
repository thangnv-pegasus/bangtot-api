<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        return response([
            'status' => 200,
            'message' => 'get data dashboard',
            'products' => DB::table('products')->limit(6)->get(),
            'images' => DB::table('image_product')->get(),
            'blogs' => DB::table('blogs')->limit(3)->get(),
            'phone' => DB::table('phone')->get()
        ]);
    }


    public function newPhone(Request $request)
    {
        try {
            $validate = $request->validate([
                'phoneName' => 'nullable',
                'phoneNumber' => 'nullable | between:9,10'
            ]);

            $phone = DB::table('phone')->insert([
                'name' => $request->phoneName,
                'phoneNumber' => $request->phoneNumber
            ]);

            return response([
                'status' => 200,
                'message' => 'Thêm số điện thoại liên hệ thành công!',
                'data' => $phone
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 201,
                'message' => 'Vui lòng điền đầy đủ thông tin!'
            ]);
        }

    }
}