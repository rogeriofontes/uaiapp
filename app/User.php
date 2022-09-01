<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    private $labels = [
        'email'     => 'Email',
        'password'  => 'Senha',
        'api_token' => 'ApiToken',
        'phone'     => 'Telefone'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'api_token', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function generateApiToken()
    {
        $this->api_token = str_random(60);
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, 'user_id', 'id');
    }
}
