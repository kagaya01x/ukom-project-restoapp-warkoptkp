<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'order_id',
        'invoice',
        'payment_method',
        'grand_total',
        'datetime',
    ];

    /**
     * Get the user who processed this transaction.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the order associated with this transaction.
     */
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'order_id');
    }
}
