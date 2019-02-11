<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function children() {
        return $this->hasMany(Quiz::class,'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Quiz::class,'parent_id');
    }
    public function questions() {
        return $this->hasMany(Question::class, 'quiz_id');
    }
    public function prizes() {
        return $this->hasMany(Prize::class, 'quiz_id');
    }
}
