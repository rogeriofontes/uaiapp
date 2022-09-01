<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends ModelDefault
{
    protected $fillable = ['role'];
    private $labels = [
        'role' => 'Regra'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getPermission()
    {
        return $this->hasMany('App\Permission');
    }
}
