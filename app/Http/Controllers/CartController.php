<?php

namespace App\Http\Controllers;

use DateTime;
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
                'idSize' => $request->sizeId,
            ]);
        }
        return response([
            'status' => 200,
            'message' => 'add product to cart is successfully',
            'cart' => [
                'idCart' => $cart_new_id,
                'idUser' => $idUser,
                'quantity' => $request->quantity,
                'productId' => $request->productId,
                'sizeId' => $request->sizeId,
                'check' => $check_product
            ],
            'request' => $request->all()
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


    public function order(Request $request)
    {

        $user_id = auth()->user()->id;
        $id_add = 1;
        $latest_id = DB::table('order')->latest()->first();
        $latest_order_guest = DB::table('order_guest')->latest()->first();
        if ($latest_id == null) {
            if ($latest_order_guest != null) {
                $id_add = $latest_order_guest->id + 1;
            }
        } else {
            if ($latest_id->id > $latest_order_guest->id) {
                $id_add = $latest_id->id + 1;
            } else {
                $id_add = $latest_order_guest->id + 1;
            }
        }
        try {

            $order_id = DB::table('order')->insertGetId([
                'id' => $id_add,
                'idUser' => $user_id,
                'name' => $request->username,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'note' => $request->note
            ]);

            $cart_id = DB::table('cart')->where('idUser', '=', $user_id)->first()->id;
            $cart_product = DB::table('cart_product')->where('idCart', '=', $cart_id)->get();

            foreach ($cart_product as $key => $prod) {
                $order_product = DB::table('order_product')->insert([
                    'idOrder' => $order_id,
                    'idProduct' => $prod->idProduct,
                    'quantity' => $prod->quantity,
                    'idSize' => $prod->idSize
                ]);
            }

            $delete = DB::table('cart_product')
                ->where('idCart', '=', $cart_id)
                ->delete();

            return response([
                'status' => 200,
                'message' => 'post order infor successed',
                'req' => $order_id,
                'cart' => $cart_product,
                'cart-id' => $cart_id,
                'latest_order' => $latest_id,
                'latest-order-guest' => $latest_order_guest
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => 'post order infor failed',
                'error' => $e,
                'req' => $request->all()
            ]);
        }

    }

    public function orderInfor(Request $request)
    {
        $user_id = auth()->user()->id;

        try {
            // $cart_id = DB::table('cart')->where('idUser','=',auth()->user()->id)->first();
            // DB::table('cart_product')->where('idCart','=',$cart_id)->delete();
            $order_infor = DB::table('order')->where('idUser', '=', $user_id)->latest()->first();
            $products = DB::table('order_product')
                ->where('idOrder', '=', $order_infor->id)
                ->join('products', 'order_product.idProduct', '=', 'products.id')
                ->join('sizes', 'sizes.id', '=', 'order_product.idSize')
                ->select('products.id', 'sizes.factor as factor', 'order_product.quantity', 'sizes.name as size_name', 'order_product.idOrder', 'products.name', 'products.price', 'products.price_sale')
                ->get();

            return response([
                'status' => 200,
                'message' => 'get order infor successed',
                'order_infor' => $order_infor,
                'products' => $products
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 200,
                'message' => 'get order infor successed',
                'error' => $e
            ]);
        }
    }

    public function billUser(Request $request)
    {
        $order = DB::table('order')
            ->join('users', 'users.id', '=', 'order.idUser')
            ->select('users.name as username', 'order.*')
            ->get();

        $order_guest = DB::table('order_guest')->get();
        $products = DB::table('order_product')
            ->join('products', 'order_product.idProduct', '=', 'products.id')
            ->join('sizes', 'sizes.id', '=', 'order_product.idSize')
            ->select('products.id', 'sizes.factor as factor', 'order_product.quantity', 'sizes.name as size_name', 'order_product.idOrder', 'products.name', 'products.price', 'products.price_sale')
            ->get();

        return response([
            'status' => 200,
            'message' => 'get data order of user is successed',
            'orders' => $order,
            'order_guest' => $order_guest,
            'products' => $products
        ]);

    }

    public function updateStatus(Request $request)
    {
        $dt = new DateTime();
        $update = DB::table('order')->where('id', '=', $request->order_id)->update([
            'status' => $request->status,
            'updated_at' => $dt->format('Y-m-d H:i:s')
        ]);
        return response([
            'status' => 200,
            'message' => 'update status is successed',
            'request' => $request->all(),
            'update' => $update,
            'order' => DB::table('order')
                ->join('users', 'users.id', '=', 'order.idUser')
                ->select('users.name as username', 'order.*')
                ->get()
        ]);
    }

    public function buynow(Request $request)
    {
        $user_id = auth()->user()->id;
        try {

            $order_id = DB::table('order')->insertGetId([
                'idUser' => $user_id,
                'name' => $request->username,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'note' => $request->note
            ]);

            $order_product = DB::table('order_product')->insert([
                'idOrder' => $order_id,
                'idProduct' => $request->productId,
                'quantity' => $request->quantity,
                'idSize' => $request->idSize
            ]);

            return response([
                'status' => 200,
                'message' => 'post order infor successed',
                'req' => $request->all(),
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => $e
            ]);
        }
    }

    public function guestCart(Request $request)
    {

        $arr = [];
        for ($i = 0; $i < count($request->cart); $i++) {
            $item = $request->cart[$i];
            $product = DB::table('products')
                ->where('products.id', '=', $item['productId'])
                ->first();
            $size = $item['size'];
            $product->factor = (int) $size['factor'];
            $product->quantity = (int) $item['quantity'];
            $product->size_name = $size['name'];
            $product->size_id = (int) $size['idSize'];
            $arr[] = $product;
        }

        return response([
            'status' => 200,
            'req' => $request->cart,
            'cart' => $arr
            // 'size_product' => DB::table('size_product')->get()
        ]);
    }

    public function orderGuest(Request $request)
    {

        $id_add = 1;
        $latest_id = DB::table('order')->latest()->first();
        $latest_order_guest = DB::table('order_guest')->latest()->first();
        if ($latest_id == null) {
            if ($latest_order_guest != null) {
                $id_add = $latest_order_guest->id + 1;
            }
        } else {
            if ($latest_id->id > $latest_order_guest->id || $latest_id->id > $latest_order_guest) {
                $id_add = $latest_id->id + 1;
            } else {
                $id_add = $latest_order_guest->id + 1;
            }
        }
        try {
            $cart = $request->cart;
            $order_id = DB::table('order_guest')->insertGetId([
                'id' => $id_add,
                'name' => $request->username,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'note' => $request->note || ""
            ]);

            foreach ($cart as $key => $item) {
                DB::table('order_product')->insert([
                    'idOrder' => $order_id,
                    'idProduct' => (int) $item['id'],
                    'quantity' => (int) $item['quantity'],
                    'idSize' => (int) $item['size_id']
                ]);
            }

            return response([
                'status' => 200,
                'message' => 'post order infor successed',
                'order_id' => $order_id,
                'latest' => $latest_id
            ]);
        } catch (Exception $e) {
            $cart0 = $cart[0];
            return response([
                'status' => 201,
                'message' => 'post order infor failed',
                'error' => $e,
                'latest' => $latest_id
            ]);
        }

    }

    public function orderInforGuest(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $products = DB::table('order_product')
                ->where('idOrder', '=', $order_id)
                ->join('products', 'order_product.idProduct', '=', 'products.id')
                ->join('sizes', 'sizes.id', '=', 'order_product.idSize')
                ->select('products.id', 'sizes.factor as factor', 'order_product.quantity', 'sizes.name as size_name', 'order_product.idOrder', 'products.name', 'products.price', 'products.price_sale')
                ->get();

            return response([
                'status' => 200,
                'message' => 'get order infor successed',
                'order_infor' => DB::table('order_guest')->where('id', '=', $order_id)->first(),
                'products' => $products
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 200,
                'message' => 'get order infor successed',
                'error' => $e
            ]);
        }
    }

    public function guestBuynow(Request $request)
    {
        $id_add = 1;
        $latest_id = DB::table('order')->latest()->first();
        $latest_order_guest = DB::table('order_guest')->latest()->first();
        if ($latest_id == null) {
            if ($latest_order_guest != null) {
                $id_add = $latest_order_guest->id + 1;
            }
        } else {
            if ($latest_id->id > $latest_order_guest || $latest_id->id > $latest_order_guest->id) {
                $id_add = $latest_id->id + 1;
            } else {
                $id_add = $latest_order_guest->id + 1;
            }
        }
        try {
            $order_id = DB::table('order_guest')->insertGetId([
                'id' => $id_add,
                'name' => $request->username,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'note' => $request->note || "khong co"
            ]);

            DB::table('order_product')->insert([
                'idOrder' => $order_id,
                'idProduct' => $request->productId,
                'quantity' => $request->quantity,
                'idSize' => $request->idSize
            ]);
            $products = DB::table('order_product')
                ->where('idOrder', '=', $order_id)
                ->join('products', 'order_product.idProduct', '=', 'products.id')
                ->join('sizes', 'sizes.id', '=', 'order_product.idSize')
                ->select('products.id', 'sizes.factor as factor', 'order_product.quantity', 'sizes.name as size_name', 'order_product.idOrder', 'products.name', 'products.price', 'products.price_sale')
                ->get();

            return response([
                'status' => 200,
                'message' => 'post order infor successed',
                'order_infor' => DB::table('order_guest')->where('id', '=', $order_id)->first(),
                'products' => $products,
                'latest_id' => $latest_id,
                'order_id' => $order_id
            ]);
        } catch (Exception $e) {
            return response([
                'status' => 201,
                'message' => $e,
                'request' => $request->all(),
                'latest_id' => $latest_id
            ]);
        }
    }
}