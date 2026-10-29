<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    /** @use HasFactory<\Database\Factories\RoleModelFactory> */
    use HasFactory;
    protected $table = 'tbl_roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name',
        'role_description'
    ];
}
