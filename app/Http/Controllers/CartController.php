<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function showAll()
    {
        $idUser = auth()->user()->id;
        $cartId = DB::table('cart')->where('idUser', '=', $idUser);
        return response([
            'status' => 200,
            'message' => 'get cart of user is successed',
            'cart' => DB::table('cart_product')->where('idCart', '=', $cartId)
        ]);
    }

    public function addProduct(Request $request)
    {
        $idUser = auth()->user()->id;

        $check_cart = DB::table('cart')->where('idUser', '=', $idUser)->first();
        if (!$check_cart) {
            DB::table('cart')->insert([
                'idUser' => $idUser
            ]);
        }
        $cart_new_id = DB::table('cart')->where('idUser', '=', $idUser)->first()->id;

        $check_product = DB::table('cart_product')
            ->where('idProduct', "=", $request->productId)
            ->where('idSize', '=', $request->sizeId)
            ->first();
        if ($check_product) {
            $pre_quantity = $check_product->quantity;
            DB::table('cart_product')->update([
                'quantity' => $pre_quantity + $request->quantity
            ]);
        } else {
            DB::table('cart_product')->insert([
                'idCart' => $cart_new_id,
                'idProduct' => $request->productId,
                'quantity' => $request->quantity,
                'idSize' => $request->sizeId
            ]);
        }
        return response([
            'status' => 200,
            'message' => 'add product to cart is successfully',
            'cart' => [
                'idUser' => $idUser,
                'quantity' => $request->quantity,
                'productId' => $request->productId,
                'sizeId' => $request->sizeId,
                'check' => $check_product
            ]
        ]);
    }

}