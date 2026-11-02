<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'menu_category';
    protected $primaryKey = 'category_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'category_name',
    ];

    /**
     * Get all menu items in this category.
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItemModel::class, 'category_id', 'category_id');
    }
}
