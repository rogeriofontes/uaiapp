<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends ModelDefault
{
    protected $fillable = ['name', 'product_sub_category_id', 'price', 'content', 'status', 'type', 'person_id', 'date_end'];

    public function getStatus()
    {
        if($this->status == '0'){
            return 'Desbloqueado';
        }

        return 'Bloqueado';
    }

    public function getType()
    {
        if($this->type == 'L'){
            return 'Loja';
        }

        return 'Aplicativo';
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }

    public function getMedias()
    {
        return $this->hasMany(ProductHasMedia::class, 'product_id', 'id')->with('getMedia');
    }

    public function getProductSubCategory()
    {
        return $this->hasOne(ProductSubCategory::class, 'id', 'product_sub_category_id');
    }

    public function getPrice()
    {
        return money_format('%.2n', $this->price);
    }

    public function getProductHasInterest()
    {
        return $this->hasMany(ProductHasInterest::class, 'product_id', 'id');
    }
}
