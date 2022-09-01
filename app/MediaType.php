<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends ModelDefault
{
    protected $fillable = ['type', 'path', 'files'];
}
