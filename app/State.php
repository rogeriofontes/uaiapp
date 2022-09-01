<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends ModelDefault
{
    protected $fillable = ['state', 'country_id'];

    public function getCountry()
    {
        return $this->hasOne(Country::class, 'state_id', 'id');
    }
}
