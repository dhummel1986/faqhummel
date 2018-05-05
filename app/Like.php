<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function questions()
    {
        return $this->belongsTo('App\Question');
    }

}
