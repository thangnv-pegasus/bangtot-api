<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\SizeTable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function showAll(Request $request)
    {
        $page_size = $request->page || 8;
        return response([
            'status' => 'ok',
            'message' => 'show all product',
            'products' => Product::paginate(8),
            'images' => DB::table('image_product')->get()
        ]);
    }

    public function getProduct($id)
    {
        $product = DB::table('products')->where('id', '=', $id)->get();
        $image = DB::table('image_product')->where('idProduct', '=', $id)->get();
        $sizes = DB::table('sizes')
            ->leftJoin('size_product', 'sizes.id', '=', 'size_product.idSize')
            ->where('idProduct', '=', $id)
            ->select('sizes.name', 'size_product.idSize','sizes.factor')
            ->get();
        $relatedProduct = DB::table('products')->where('collection_id','=',$product[0]->collection_id)->limit(4)->get();
        return response([
            'status' => 200,
            'message' => 'get product is successed',
            'product' => $product,
            'images' => $image,
            'sizes' => $sizes,
            'related' => $relatedProduct
        ]);
    }

    public function firstProduct($idCollection)
    {
        return response([
            'status' => 200,
            'message' => 'get product in collection is successfully',
            'product' => DB::table('products')
                ->join('image_product','image_product.idProduct','=','products.id')
                ->select('image_product.name as imageUrl', 'products.*')
                ->where('products.collection_id', '=', $idCollection)
                ->first()
        ]);
    }

    public function addProduct(Request $request)
    {

        try {
            $validate = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
                'detail' => 'required',
                'collectionId' => 'required',
            ]);

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'price_sale' => $request->price_sale || 0,
                'description' => $request->description,
                'detail' => $request->detail,
                'collection_id' => $request->collectionId
            ]);
            $images = $request->image;
            $sizes = $request->sizes;
            foreach ($images as $key => $image) {
                DB::table('image_product')->insert([
                    'idProduct' => $product->id,
                    'name' => $image['url'],
                    'description' => $image['publicId']
                ]);
            }
            foreach ($sizes as $key => $size) {
                DB::table('size_product')->insert([
                    'idProduct' => $product->id,
                    'idSize' => $size['id'],
                ]);
            }
            return response([
                'status' => '200',
                'message' => 'create product successfully',
                'product' => $product,
                'collectionid' => $request->collectionId
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => '422',
                'message' => 'create product failed',
                'error' => $th,
                'req' => $request->all()
            ]);
        }

    }

    public function showCollection()
    {
        return response([
            'status' => '200',
            'collections' => Collection::all()
        ]);
    }

    public function lastProduct()
    {
        $pLastest = Product::latest()->first();
        if ($pLastest == null) {
            $id = -1;
        } else {
            $id = $pLastest->id;
        }
        return response([
            'id' => $id
        ]);
    }

    public function formData(Request $request)
    {
        return response([
            'status' => '200',
            'message' => 'get data successfully',
            'collections' => Collection::all(),
            'sizes' => Size::all(),
        ]);
    }


    public function getImage($id)
    {
        return response([
            'status' => 200,
            'message' => 'get image of product is successed',
            'image' => DB::table('image_product')->where('idProduct', '=', $id)->get()
        ]);
    }

    public function getByCollection($id)
    {
        return response([
            'status' => 200,
            'message' => 'get first product is successfully',
            'products' => DB::table('products')->where('collection_id', '=', $id)->get()
        ]);
    }


}