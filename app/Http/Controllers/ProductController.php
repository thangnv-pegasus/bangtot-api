<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function showAll()
    {
        return response([
            'status' => 'ok',
            'message' => 'show all product',
            'data' => Product::paginate(8)
        ]);
    }

    public function getProduct($id)
    {
        return 'this is product ' . $id;
    }

    public function getByCollection($collection)
    {
        return 'this is product of collection id ' . $collection;
    }

    public function addProduct(Request $request)
    {

        try {
            $validate = $request->validate([
                'name' => 'required',
                'price' => 'required | numeric',
                'price_sale' => 'required | numeric',
                'description' => 'required',
                'detail' => 'required',
                'collectionId' => 'required',
            ]);

            $images = $request->image;
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'price_sale' => $request->price_sale,
                'description' => $request->description,
                'detail' => $request->detail,

            ]);


            return response([
                'status' => '200',
                'message' => 'create product successfully',
                'product' => $request->image,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => '422',
                'message' => 'create product failed',
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

}