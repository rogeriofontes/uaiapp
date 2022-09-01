<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends ModelDefault
{
    protected $fillable = ['cep', 'address', 'neighborhood', 'number', 'complement', 'city_id',
                           'person_id', 'latitude', 'longitude'];
    
    public function getCity()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }

    public function getPerson()
    {
        return $this->hasOne('App\Person', 'id', 'person_id');
    }

    public function getCityAttribute()
    {
        return $this->getCity->city;
    }

    public function getStateAttribute()
    {
        return $this->getCity->getState->state;
    }
}
