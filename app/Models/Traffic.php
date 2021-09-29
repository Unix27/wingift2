<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{

    protected $table = 'traffic';

    protected $fillable = ['clickid','action','us_id','partner'];

    public function user(){
        return $this->belongsTo(User::class,'us_id','id');
    }

}
