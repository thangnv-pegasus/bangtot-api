<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function showAll()
    {
        $idUser = auth()->user()->id;
        $cartId = DB::table('cart')->where('idUser','=',$idUser);
        return response([
            'status' => 200,
            'message' => 'get cart of user is successed',
            'cart' => DB::table('cart_product')->where('idCart','=',$cartId)
        ]);
    }

    public function addProduct($id, $q)
    {
        $idUser = auth()->user()->id;
        return response([
            'status' => 200,
            'message' => 'add product to cart is successfully',
            'cart' => [
                'idUser' => $idUser,
                'quantity' => $q,
                'productId' => $id
            ]
            ]);
    }

}