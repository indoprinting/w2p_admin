<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestSeller extends Model
{
    use HasFactory;
    protected $table = 'idp_best_seller';
    protected $guarded = ['id'];

    public function getBestSeller($month, $outlet)
    {
        return BestSeller::selectRaw('SUM(qty) as sold_out,SUM(price) as total,name,thumbnail')
            ->when($outlet, fn ($query) => $query->where('outlet', 'like', $outlet . '%'))
            ->whereNotIn('id_product', [197])->where('created_at', 'like', $month . '%')
            ->groupBy('id_product')->latest('sold_out')->get();
    }

    public function getDataChart($month, $outlet)
    {
        $data_chart = [];
        $datas = BestSeller::selectRaw('SUM(qty) as sold_out,SUM(price) as total,name')
            ->when($outlet, fn ($query) => $query->where('outlet', 'like', $outlet . '%'))
            ->where('created_at', 'like', $month . '%')->whereNotIn('id_product', [197])
            ->groupBy('id_product')->latest('sold_out')->take(25)->get();
        foreach ($datas as $data) :
            $chart = [
                'label' => substr($data->name, 0, 10) . '...',
                'name'  => $data->name,
                'total' => rupiah($data->total),
                'y'     => $data->sold_out,
                'indexLabelOrientation' => 'vertical',
            ];
            array_push($data_chart, $chart);
        endforeach;

        return json_encode($data_chart, JSON_NUMERIC_CHECK);
    }
}
