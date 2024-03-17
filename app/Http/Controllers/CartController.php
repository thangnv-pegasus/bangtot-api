<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function showAll(Request $request)
    {
        try {
            $idUser = auth()->user()->id;
            $cartId = DB::table('cart')->where('idUser', '=', $idUser)->first()->id;
            return response([
                'status' => 200,
                'message' => 'get cart of user is successed',
                'cart' => DB::table('cart_product')
                    ->where('idCart', '=', $cartId)
                    ->join('products', 'cart_product.idProduct', '=', 'products.id')
                    ->join('sizes', 'sizes.id', '=', 'cart_product.idSize')
                    ->select(
                        'cart_product.id as cart_product_id',
                        'products.name',
                        'products.id',
                        'products.price',
                        'products.price_sale',
                        'cart_product.quantity',
                        'sizes.name as size_name',
                        'sizes.id as idSize',
                        'sizes.factor'
                    )
                    ->get()
            ]);
        } catch (\Exception $e) {
            return response([
                'error' => $e,
                'cart' => []
            ]);
        }
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

    public function update(Request $request)
    {
        try {
            $cart_id = DB::table('cart')->where('idUser', '=', auth()->user()->id)->first()->id;
            $update = DB::table('cart_product')
                ->where('idCart', '=', $cart_id)
                ->where('idProduct', '=', $request->productId)
                ->where('idSize', '=', $request->sizeId)
                ->update([
                    'quantity' => $request->quantity
                ]);


            return response([
                'status' => 200,
                'message' => 'update cart successed',
                'cart' => DB::table('cart_product')
                    ->where('idCart', '=', $cart_id)
                    ->where('idProduct', '=', $request->productId)
                    ->get(),
            ]);
        } catch (Exception $e) {
            return response([
                'error' => $e
            ]);
        }

    }

    public function delete(Request $request, $id)
    {
        try {
            $cart_id = DB::table('cart')->where('idUser', '=', auth()->user()->id)->first()->id;

            $delete = DB::table('cart_product')
                ->where('id', '=', $id)
                ->delete();

            return response([
                'status' => 200,
                'message' => 'delete product successed',
                'request' => $request->all(),
                'cart' => DB::table('cart_product')
                    ->where('idCart', '=', $cart_id)
                    ->join('products', 'cart_product.idProduct', '=', 'products.id')
                    ->join('sizes', 'sizes.id', '=', 'cart_product.idSize')
                    ->select(
                        'cart_product.id as cart_product_id',
                        'products.name',
                        'products.id',
                        'products.price',
                        'products.price_sale',
                        'cart_product.quantity',
                        'sizes.name as size_name',
                        'sizes.id as idSize',
                        'sizes.factor'
                    )
                    ->get()
            ]);


        } catch (Exception $e) {
            return response([
                'error' => $e
            ]);
        }
    }

}