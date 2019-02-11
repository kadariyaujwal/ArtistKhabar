<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['location','title','description','date'];
    public function artists(){
        return $this->belongsToMany('App\Artist','artists_events');
    }

    public function photos(){
        return $this->hasMany('App\EventPhoto','event_id','id');
    }

    public function getMainPhotoAttribute(){
        return $this->photos->where('cover','=','1');
    }

    public function contains_artist($artist){
        foreach($this->artists as $eventartist){
            if($eventartist->id == $artist->id){
                return 'selected';
            }
        }
            return '';
    }

}
