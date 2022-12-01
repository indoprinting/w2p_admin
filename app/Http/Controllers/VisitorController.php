<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $title      = "Semua Visitor";
        $date       = $request->date ?? date('Y-m');
        $visitors   = DB::table('idp_visitor')->where('created_at', 'like', $date . '%')->orderBy('id', 'desc')->get();
        $pc         = DB::table('idp_visitor')->where('is_mobile', 0)->count('is_mobile');
        $mobile     = DB::table('idp_visitor')->where('is_mobile', 1)->count('is_mobile');

        return view('visitor.index_visitor', compact('title', 'visitors', 'pc', 'mobile'));
    }

    public function dailyVisitor(Request $request)
    {
        $title      = "Daily Visitor";
        $date       = $request->date ?? date('Y-m');
        $visitors   = DB::table('idp_visitor_today')->where('created_at', date('Y-m-d'))->get();
        $pc         = DB::table('idp_visitor_today')->where(['created_at' => date('Y-m-d'), 'is_mobile' => 0])->count('is_mobile');
        $mobile     = DB::table('idp_visitor_today')->where(['created_at' => date('Y-m-d'), 'is_mobile' => 1])->count('is_mobile');
        $data_chart = DB::table("idp_visitor_today")->selectRaw('DAY(created_at) as label, COUNT(id) as y')->where('created_at', 'like', $date . '%')->groupBy('created_at')->get();
        $chart      = json_encode($data_chart, JSON_NUMERIC_CHECK);

        return view('visitor.index_visitor', compact('title', 'visitors', 'chart', 'pc', 'mobile'));
    }
}
