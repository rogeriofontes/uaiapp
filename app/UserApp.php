<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApp extends ModelDefault
{
    protected $fillable = ['person_id', 'token', 'status'];
    private $labels = [
        'person_id' => 'Pessoa',
        'status'    => 'Status',
        'token'     => 'Token'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }

    public function getStatus()
    {
        if($this->status == '0'){
            return 'Inativo';
        }

        return 'Ativo';
    }
}
