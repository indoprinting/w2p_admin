<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table    = 'idp_products';
    protected $primaryKey = 'id_product';
    protected $guarded = ['id_product'];

    public function getProduct($request)
    {
        $count  = Product::count();
        return Product::with('kategori')
            ->latest()
            ->when(
                $request->keyword,
                fn ($query, $keyword) => $query->where('name', 'like', "%{$keyword}%")
            )->when(
                $request->display == 1,
                fn ($query) => $query->paginate($count),
                fn ($query) => $query->paginate(15)
            )->withQueryString();
    }

    public function store($request, $thumbnail, $thumbnail2, $bahan, $size, $custom, $stages)
    {
        return $this->updateOrCreate(
            ['id_product'   => $request->id_product],
            [
                'name'          => $request->name,
                'desc_id'       => $request->desc_id,
                'category'      => $request->category,
                'min_order'     => $request->min_order,
                'min_isi'       => $request->min_isi ?? 1,
                'min_luas'      => $request->min_luas ?? 0,
                'min_ukuran'    => $request->min_ukuran ?? 0,
                'unit_measure'  => $request->unit_measure,
                'weight'        => $request->berat,
                'panjang'       => $request->panjang,
                'lebar'         => $request->lebar,
                'tinggi'        => $request->tinggi,
                'customize'     => $request->customize ?? 0,
                'luas'          => $request->luas ?? 0,
                'mmt_fixed'     => $request->mmt_fixed ?? 0,
                'thumbnail'     => $thumbnail,
                'min_price'     => $bahan['material_min_price'],
                'thumbnail2'    => $thumbnail2,
                'material'      => json_encode($bahan),
                'size'          => $size,
                'attributes'    => $custom,
                'stages'        => $stages,
            ]
        );
    }

    public function kategori()
    {
        return $this->belongsTo(ProductCategory::class, 'category', 'id_category');
    }
}
