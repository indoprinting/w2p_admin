<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'adm_menu';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function getMenu()
    {
        // return cache()->rememberForever('semua_menu', fn () => Menu::with('category')->latest('id')->get());
        return cache()->remember('semua_menu', cacheTime(), fn () => Menu::with('category')->latest('id')->get());
    }

    public function category()
    {
        return $this->belongsTo(CategoryMenu::class, 'category_id', 'id');
    }

    public function access()
    {
        return $this->hasOne(UserAccess::class, 'menu_id', 'id');
    }
}
