<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
	use CrudTrait;
    use HasRoles;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'phone',
        'card_token',
        'is_new'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = url("/reset-password/$token?email=" . $this->email);

        $this->notify(new ResetPasswordNotification($url));
    }


    
    public function cloudSubscriptions() {
        return $this->hasMany(CloudPaymentsSubscription::class);
    }

    public function getFullnameAttribute()
    {
        return $this->name . ' ' . $this->lastname;
    }

    public function getIsSubscribedAttribute()
    {
        return $this->cloudSubscriptions()->active()->first();
        //return $this->cloudSubscriptions()->count() && $this->cloudSubscriptions()->max('nextTransactionDate') >= now();
    }

    public function getActiveSubscriptionAttribute()
    {
        return $this->cloudSubscriptions()->activeSubscription()->first();
    }

    public function getFailedSubscriptionAttribute()
    {
        return $this->cloudSubscriptions()->failedSubscription()->first();
    }
    public function history()
    {
        return $this->hasMany(\App\Models\UserHistory::class, 'user_id');
    }
}
