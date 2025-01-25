<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chart extends Controller
{
    


    public function index()
    {
        
        try {
            
            $result = DB::table('investments as i')
                ->join('investmentcompanies as c', 'i.investmentcompanyid', '=', 'c.id')
                ->where('i.isdeleted', 0)
                ->select(DB::raw('DATE(i.maturitydate) as maturity_date'), DB::raw('SUM(i.maturityamount) as total_investment'))
                ->groupBy(DB::raw('DATE(i.maturitydate)'))
                ->orderBy('maturity_date')
                ->get();

            if ($result->isEmpty()) {
                return view('chart')->with('chartData', '');
            }

            
            $chartData = '';
            foreach ($result as $list) {
                $chartData .= "['" . $list->maturity_date . "', " . $list->total_investment . "],";
            }

            $chartData = rtrim($chartData, ',');

            return view('chart', compact('chartData'));

        } catch (\Exception $e) {
            
            return view('chart')->with('chartData', '');
        }
    }
}