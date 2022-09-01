<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends ModelDefault
{
    protected $fillable = ['phone', 'person_id', 'type'];

    public function getPerson()
    {
        return $this->hasOne('App\Person');
    }
}
