<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chartController extends Controller
{
    //direct chart list page
    public function list()
    {
        $sale = Order::Select(DB::raw('SUM(total_price) as total'),DB::raw("MONTHNAME(created_at) as month_name"))
                    ->groupBy(DB::raw('month_name'))
                    ->whereYear('created_at',date('Y'))
                    ->orderBy('created_at','asc')
                    ->get();

        $sale1 = Order::Select(DB::raw('SUM(total_price) as total'),DB::raw("MONTHNAME(created_at) as month_name"))
                    ->groupBy(DB::raw('month_name'))
                    ->whereYear('created_at',date('Y')-1)
                    ->orderBy('created_at','asc')
                    ->get();

        $view = View::Select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw('count(*) as count'))
                    ->groupBy(DB::raw('month_name'))
                    ->whereYear('created_at',date('Y'))
                    ->orderBy('created_at','asc')
                    ->get();

        $view1 = View::Select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw('count(*) as count'))
                    ->groupBy(DB::raw('month_name'))
                    ->whereYear('created_at',date('Y')-1)
                    ->orderBy('created_at','asc')
                    ->get();

        return view('admin.charts.list',compact('sale','sale1','view','view1'));
    }
}
