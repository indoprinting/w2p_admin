<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorOnline extends Model
{
    use HasFactory;
    protected $table = 'idp_design';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
}
