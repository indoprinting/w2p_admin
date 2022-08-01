<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;
    protected $table = 'adm_menu_access';
    protected $guarded = ['id'];
    public $timestamps = false;
}
