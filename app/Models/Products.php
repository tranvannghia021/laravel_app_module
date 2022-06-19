<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
 

    protected $fillable=[
        'title',
        'price',
        'category_id',
        'quantity',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];
}
