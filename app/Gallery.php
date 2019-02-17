<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function images() {
        return $this->hasMany(GalleryImage::class);
    }

    public function artist() {
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
