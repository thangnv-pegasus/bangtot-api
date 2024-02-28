<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCollection',
        'path',
        'title'
    ];

    // kiem tra xem itemCollection nay dang thuoc collection nao
    // public function items()
    // {
    //     return $this->BelongsTo(Collection::class, 'idCollection');
    // }

}