<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class UserHistory extends Model
{
	// use CrudTrait;
 //    use HasRoles;
 //    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    // History statuses:
    //  - Subscribed   (Подписался)
    //  - Unsubscribed (Отписался)
    //  - Renewed      (Продлил подписку)
    //  - Unrenewed    (Не продлил подписку)
    
    protected $table = 'user_history';

    protected $fillable = [
        'user_id',
        'action',
    ];

    public function history(){
        return $this->belongsTo(User::class);
    }


  
}