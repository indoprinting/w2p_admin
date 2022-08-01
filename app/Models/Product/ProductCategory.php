<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = "adm_product_categories";
    protected $primaryKey = "id_category";
    protected $guarded  = ['id_category'];

    public function getCategory()
    {
        return cache()->rememberForever('category-product', fn () => ProductCategory::get());
    }
}
