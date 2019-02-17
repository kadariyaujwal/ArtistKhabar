<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtistImage extends Model
{
    protected $fillable = ['artist_id','url'];
    protected $table = "artist_picture";
}
