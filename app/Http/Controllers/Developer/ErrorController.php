<?php

namespace App\Http\Controllers\Developer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ErrorController extends Controller
{
    public function index(Request $request)
    {
        $date1  = $request->date1 ?? Carbon::now()->subDays(30);
        $date2  = $request->date2 ?? Carbon::now();
        $title  = "Report error";
        $errors =   DB::table('adm_error_report')->whereBetween('created_at', [$date1, $date2])->latest()->get();

        return view('developer.error.index_error', compact('title', 'errors'));
    }
}
