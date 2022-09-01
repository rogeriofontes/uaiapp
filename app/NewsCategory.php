<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends ModelDefault
{
    protected $fillable = ['category'];
    private $labels = [
        'category' => 'Categoria'
    ];

    public function getLabels()
    {
        return $this->labels;
    }
}
