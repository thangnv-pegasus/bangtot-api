<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'code' => '200',
            'collections' => Collection::all(),
            'collectionItems' => CollectionItem::all(),
        ], 200);
    }

    public function header()
    {
        return response([
            'status' => 200,
            'message' => 'get data header success',
            'collections' => Collection::all(),
            'collectionItems' => CollectionItem::all(),
        ]);
    }
}