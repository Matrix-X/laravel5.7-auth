<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'db_member';

    const STATUS_NORMAL = 'use';
    const STATUS_STOP = 'stop';
    const STATUS_BREAK_OFF = 'breakoff';
    const STATUS_DELETE = 'del';





    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be table primary key.
     *
     * @var string
     */
    protected $primaryKey = 'member_id';


    public function findForPassport($username)
    {
//        dd($username);
        $user = User::where('phone', $username)
            ->where("state",User::STATUS_NORMAL)
//            ->orWhere('name',$username)
//            ->orWhere('mobole1',$username)
//            ->orWhere('mobile2',$username)
            ->first();
//        dd($user);
        return $user;

    }

    public function validateForPassportPasswordGrant($password)
    {
        $AuthPassword = $this->getAuthPassword();
//        var_dump($AuthPassword);
        $encodePassword = encryptPassword($password);
//        var_dump($encodePassword);

        $bResult = $encodePassword == $AuthPassword;

        return $bResult;

    }



}
