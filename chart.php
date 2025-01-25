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
                ->select('c.name as company_name', DB::raw('SUM(i.maturityamount) as total_investment'))
                ->groupBy('c.name') 
                ->orderBy('c.name')
                ->get();

            
            if ($result->isEmpty()) {
                return view('chart')->with('chartData', '');
            }

            
            $chartData = '';
            foreach ($result as $list) {
                $chartData .= "['" . $list->company_name . "', " . $list->total_investment . "],";
            }

            
            $chartData = rtrim($chartData, ',');

            
            return view('chart', compact('chartData'));

        } catch (\Exception $e) {
            
            return view('chart')->with('chartData', '');
        }
    }
}