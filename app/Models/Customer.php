<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'idp_customers';
    protected $primaryKey = 'id_customer';
    protected $guarded = ['id_customer'];

    public function order()
    {
        return $this->hasMany(Order::class, 'cust_id', 'id_customer');
    }
}
