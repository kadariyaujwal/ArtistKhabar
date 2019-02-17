<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Artist extends Model
{
    use SoftDeletes;
    public  function images() {
        return $this->hasMany(ArtistImage::class,'artist_id','id');
    }

    public function movies() {
        return $this->belongsToMany(Movie::class);
    }

    public function events(){
        return $this->belongsToMany('App\Event','artists_events');
    }

    public function gallery() {
        return $this->hasMany(Gallery::class, 'artist_id');
    }
}
