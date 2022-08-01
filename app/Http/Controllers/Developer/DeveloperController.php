<?php

namespace App\Http\Controllers\Developer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeveloperController extends Controller
{
    public function clearCache()
    {
        DB::table('adm_cache')->whereNotIn('key', ['cache_warehouse_erp'])->delete();
        return back();
    }

    public function clearCacheProductERP()
    {
        DB::table('adm_cache')->where('key', 'cache_warehouse_erp')->delete();
        return back();
    }
}
