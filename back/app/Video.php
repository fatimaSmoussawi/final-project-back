<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'url' , 'start' , 'end' , 'newUrl','title','description','thumbnail'.'user_id'
    ];
        public function user(){ return $this->belongsTo(user::class);}

}
