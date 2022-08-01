<?php

namespace App\Models\Product;

use App\Models\Customer;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;
    protected $table = 'idp_review';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_user', 'id_customer');
    }
}
