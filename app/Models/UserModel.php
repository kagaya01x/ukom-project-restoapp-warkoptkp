<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\EmployeeModel;
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

    public function userEmployee()
    {
        return $this->hasOne(UserEmployeeModel::class, 'user_id', 'id');
    }

    public function employee()
    {
        // Parameter: Model tujuan, Model perantara, foreign key di tabel perantara, foreign key di tabel tujuan
        return $this->hasOneThrough(
            EmployeeModel::class,
            UserEmployeeModel::class,
            'user_id',    // Foreign key di tabel users_employees yang mengarah ke users
            'employee_id', // Foreign key di tabel tbl_employee yang menjadi primary key-nya
            'user_id',          // Local key di tabel users
            'employee_id'  // Local key di tabel users_employees
        );
    }

    // public function findForPassport($username)
    // {
    //     return $this->where('username', $username)->first();
    // }
    
}
