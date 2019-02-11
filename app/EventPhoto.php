<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    //
    protected $table = "event_photos";
    protected $fillable = ['event_id', 'cover', 'path'];

    public function event(){
        return $this->belongsTo('App\Event');
    }
}
