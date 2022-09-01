<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends ModelDefault
{
    protected $dates = ['date'];
    protected $fillable = ['date', 'title', 'subtitle', 'content', 'news_category_id', 'media_id'];
    private $labels = [
        'date'              => 'Data',
        'title'             => 'Título',
        'subtitle'          => 'Sub Título',
        'content'           => 'Descrição',
        'news_category_id'  => 'Categoria',
        'media_id'          => 'Foto'
    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getCategory()
    {
        return $this->hasOne(NewsCategory::class, 'id', 'news_category_id');
    }

    public function getMedia()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }
    
}
