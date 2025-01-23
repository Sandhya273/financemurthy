<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chart extends Controller
{
    


    public function index()
    {
        
        $result = DB::select("
            SELECT
                c.name AS bank_organization_name,
                SUM(i.maturityamount) AS total_investment
            FROM
                investments i
            JOIN
                investmentcompanies c ON i.investmentcompanyid = c.id
            WHERE
                i.isdeleted = 0
            GROUP BY
                c.name
            ORDER BY
                total_investment DESC
        ");

        $chartData = '';

        
        foreach ($result as $list) {
            
            $chartData .= "['" . addslashes($list->bank_organization_name) . "', " . $list->total_investment . "],";
        }

        
        $chartData = rtrim($chartData, ",");

        
        return view('chart', compact('chartData'));
    }
}