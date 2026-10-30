<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\Contracts\OAuthenticatable;
// use Laravel\Passport\HasApiTokens;


class UserModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserModelFactory> */
    use HasFactory, /*HasApiTokens,*/ Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username', 
        'password',
        'role_id'
    ];
    protected $hidden = [
        'password', 
        'remember_token'
    ];

    // public function findForPassport($username)
    // {
    //     return $this->where('username', $username)->first();
    // }
    
}
