<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends ModelDefault
{
    protected $fillable = ['subcategory', 'product_category_id'];
    private $labels = [
        'subcategory'           => 'Sub Categoria',
        'product_category_id'   => 'Categoria'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }
}
