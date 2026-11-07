<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\Contracts\OAuthenticatable;
// use Laravel\Passport\HasApiTokens;


// class EmployeeModel extends Authenticatable implements OAuthenticatable
class EmployeeModel extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeModelFactory> */
    use HasFactory, /*HasApiTokens,*/ Notifiable;

    protected $table = 'tbl_employee';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'name',
        'position',
        'employee_id',
        'image_link'
    ];

    public function employeeUser()
    {
        return $this->hasOne(UserEmployeeModel::class, 'employee_id', 'employee_id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            UserModel::class, 
            UserEmployeeModel::class, 
            'employee_id', 
            'user_id', 
            'employee_id', 
            'user_id');
    }
}
