<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function showAll(){
        return 'all blogs';
    }

    public function getBlog($id){
        return 'this is blog id ' . $id;
    }

}
