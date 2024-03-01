<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request){
        return response([
            'status' => 200,
            'message' => 'get data dashboard',
            'products' => DB::table('products')->limit(6)->get(),
            'images' => DB::table('image_product')->get(),
            'blogs' => DB::table('blogs')->limit(3)->get(),
            'phone' => DB::table('phone')->get()
        ]);
    }
}
