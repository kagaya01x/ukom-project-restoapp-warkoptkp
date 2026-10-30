<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\HasApiTokens;
use App\Models\UserModel;
use App\Models\EmployeeModel;

class UserEmployeeModel extends Model
{
    use /*HasApiTokens,*/ Notifiable;
    protected $table = 'user_employee';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = [
        'user_id',
        'employee_id'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id');
    }
}
