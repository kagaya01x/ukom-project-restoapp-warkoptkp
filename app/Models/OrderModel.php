<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'datetime',
        'desc',
        'order_status',
    ];

    /**
     * Get the user who created this order.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Get all items in this order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id', 'order_id');
    }

    /**
     * Get the transaction associated with this order.
     */
    public function transaction()
    {
        return $this->hasOne(TransactionModel::class, 'order_id', 'order_id');
    }
}
