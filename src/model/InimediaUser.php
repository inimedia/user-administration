<?php

namespace Inimedia\UserAdministration\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class InimediaUser extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'phone',
//        'status',
//        'type',
//        'photo_url',
//        'activation_code',
//        'reference_type',
//        'reference_id',
//        'fp',
//        'ip'
//    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reference()
    {
        return $this->morphTo();
    }

}
