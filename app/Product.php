<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'productName', 'productDescription', 'productPrice', 'productCategory' 'productImage', 'category_id', 'productStatus'
    ];

    function category(){
        return $this->belongsto('App\Category');
    }
}
