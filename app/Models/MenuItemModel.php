<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemModel extends Model
{
    use HasFactory;

    protected $table = 'menu_items';
    protected $primaryKey = 'menu_item_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'category_id',
        'item_menu_name',
        'item_menu_price',
        'item_menu_desc',
        'item_menu_img_link',
    ];

    /**
     * Get the category this menu item belongs to.
     */
    public function category()
    {
        return $this->belongsTo(MenuCategoryModel::class, 'category_id', 'category_id');
    }

    /**
     * Get all order items referencing this menu item.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'menu_item_id', 'menu_item_id');
    }
}
