<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showAll()
    {
        return 'this is all product in cart';
    }

    public function addProduct($id, $q)
    {
        return 'this is product ' . $id . ' quantity = ' . $q;
    }
}