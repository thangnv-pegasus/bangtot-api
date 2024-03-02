<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneController extends Controller
{
    public function getAll(){
        return response([
            'status' => 200,
            'message' => 'get all hotline of page success',
            'phones' => DB::table('phone')->limit(3)->get()
        ]);
    }
}
