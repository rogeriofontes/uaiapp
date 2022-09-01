<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends ModelDefault
{
    protected $fillable = ['category', 'media_id'];
    private $labels = [
        'category' => 'Categoria',
        'media_id' => 'Ícone'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getMedia()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }

    public function getProductSubCategory()
    {
        return $this->hasMany(ProductSubCategory::class, 'product_category_id', 'id')->select(['id', 'subcategory', 'product_category_id'])->orderBy('subcategory', 'asc');
    }
}
