<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends ModelDefault
{
    protected $fillable = ['plan', 'days', 'price'];
    protected $labels = ['plan' => 'Plano', 'days' => 'Dias', 'price' => 'Preço'];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getPrice()
    {
        if ($this->price <> 0) {
            return "R$ " . number_format($this->price, 2, ',', '.');
        } else {
            return 'Gratuito';
        }
    }
}
