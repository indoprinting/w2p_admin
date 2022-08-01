<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMenu extends Model
{
    use HasFactory;
    protected $table = 'adm_menu_category';

    public function menu()
    {
        return $this->hasMany(Menu::class, 'category_id', 'id');
    }

    public function access()
    {
        return $this->hasOne(UserAccess::class, 'category_id', 'id');
    }
}
