<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorys extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'id_category',
        'name',
        'created_at',
        'updated_at',
    ];
}
