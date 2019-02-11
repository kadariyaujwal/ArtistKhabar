<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    public function quiz() {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
