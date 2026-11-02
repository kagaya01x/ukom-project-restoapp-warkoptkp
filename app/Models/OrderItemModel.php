<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    use HasFactory;

    protected $table = 'order_item';
    protected $primaryKey = 'order_item_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'item_name',
        'item_quantity',
        'item_price',
        'sub_total',
    ];

    /**
     * Get the order this item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'order_id');
    }

    /**
     * Get the menu item (may be null if the menu item was deleted).
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItemModel::class, 'menu_item_id', 'menu_item_id');
    }
}
