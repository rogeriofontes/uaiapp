<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasMedia extends Model
{
    protected $fillable = ['media_id', 'product_id'];
    public $timestamps = false;

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getMedia()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }
}
