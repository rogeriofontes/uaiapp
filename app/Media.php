<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends ModelDefault
{
    protected $fillable = ['media', 'path', 'thumbnail_path', 'media_type_id'];

    public function getMediaType()
    {
        return $this->hasOne('App\MediaType');
    }
}
