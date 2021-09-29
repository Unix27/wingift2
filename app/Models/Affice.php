<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affice extends Model
{

    protected $table = 'affice';

    protected $fillable = ['affice','action','us_id'];

    public function user(){
        return $this->belongsTo(User::class,'us_id','id');
    }

}
