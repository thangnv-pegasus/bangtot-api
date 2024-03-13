<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'price_sale',
        'collection_id',
        'idSize',
        'idImage',
        'description',
        'detail',
        'update_at',
        'create_at'
    ];
}