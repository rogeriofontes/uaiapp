<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends ModelDefault
{
    protected $fillable = ['menu', 'icon', 'route', 'show', 'menu_id'];
    private $labels = [
        'menu'      => 'Menu', 
        'icon'      => 'Ícone', 
        'route'     => 'Rota', 
        'show'      => 'Mostrar', 
        'menu_id'   => 'Menu Pai'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getShow()
    {
        if($this->show == '1'){
            return 'Sim';
        }

        return 'Não';
    }

    public function getChildren()
    {
        return $this->hasMany('App\Menu');
    }
}
