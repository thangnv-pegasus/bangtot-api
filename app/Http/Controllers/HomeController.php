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
        $user = auth('sanctum')->user();
        if ($user) {
            return response()->json([
                'code' => '200',
                'collections' => Collection::all(),
                'collectionItems' => CollectionItem::all(),
                'user' => $user
            ], 200);
        }
        return response()->json([
            'code' => '200',
            'collections' => Collection::all(),
            'collectionItems' => CollectionItem::all(),
        ], 200);
    }
}