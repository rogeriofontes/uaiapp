<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends ModelDefault
{
    protected $fillable = ['person_id'];
    protected $labels   = ['person_id'  => 'ID da Pessoa'];
    
    public function getLabels()
    {
        return $this->labels;
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }
}
