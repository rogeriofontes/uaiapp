<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fcm extends Model
{
    protected $fillable = ['token', 'device_id', 'user_app_id'];
    protected $labels = ['token' => 'Token', 'device_id' => 'Id do dispositivo', 'user_app_id' => 'Usuário'];

    public function getLabels() 
    {
        return $this->labels;
    }

    public function getUserApp()
    {
        return $this->hasOne(UserApp::class, 'id', 'user_app_id');
    }
}
