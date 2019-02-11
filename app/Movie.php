<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function actorlist() {
        return $this->belongsToMany(Artist::class);
    }
    public function leadactor() {
        return $this->belongsTo(Artist::class, 'lead_actor');
    }
}
