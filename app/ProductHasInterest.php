<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasInterest extends ModelDefault
{
    protected $fillable = ['product_id', 'status', 'user_app_id'];

    public function getStatus()
    {
        if($this->status == '0'){
            return 'Negociando';
        }else if($this->status == '1'){
            return 'Vendido';
        }

        return 'Cancelado';
    }

    public function getUserApp()
    {
        return $this->hasOne(UserApp::class, 'id', 'user_app_id');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
