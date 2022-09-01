<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends ModelDefault
{
    protected $fillable = ['name', 'birthday', 'type_person', 'cpf_cnpj', 'user_id', 'media_id', 'role_id', 'ie'];
    protected $labels = ['name' => 'Nome', 'birthday' => 'Data de Nascimento', 'type_person' => 'Tipo de Pessoa', 'media_id' => 'Imagem', 'role_id' => 'Permissão', 'cpf_cnpj' => 'CPF/CNPJ', 'phone' => 'Telefone', 'ie' => 'Inscrição Estadual'];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getRole()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function getPhone()
    {
        return $this->hasOne(Phone::class, 'person_id', 'id');
    }

    public function getMedia()
    {
        return $this->hasOne('App\Media', 'id', 'media_id');
    }

    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getType()
    {
        if($this->type_person == 'J'){
            return "Jurídica";
        }

        return "Física";
    }

    public function getOperator()
    {
        return $this->hasOne('App\Operator', 'person_id', 'id');
    }

    public function getUserApp()
    {
        return $this->hasOne(UserApp::class, 'person_id', 'id');
    }

    public function getStore()
    {
        return $this->hasOne('App\Store', 'person_id', 'id');
    }

    public function getAddress()
    {
        return $this->hasOne('App\Address', 'person_id', 'id');
    }
}
