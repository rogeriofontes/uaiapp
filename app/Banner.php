<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends ModelDefault
{
    protected $fillable = ['title', 'link', 'media_id'];
    protected $labels = [
        'title'     => 'Título',
        'link'      => 'Link',
        'media_id'  => 'Imagem'
    ];
    
    public function getLabels()
    {
        return $this->labels;
    }

    public function getMedia()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }
}
