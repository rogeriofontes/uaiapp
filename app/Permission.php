<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['menu_id', 'role_id'];
    public $timestamps = false;

    public function getMenu()
    {
        return $this->hasOne('App\Menu', 'id', 'menu_id');
    }

    public function getRole()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
}
