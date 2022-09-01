<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends ModelDefault
{
    protected $fillable = ['city', 'state_id'];

    public function getState()
    {
        return $this->hasOne('App\State', 'id', 'state_id');
    }
}
