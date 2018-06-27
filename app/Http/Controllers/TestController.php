<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function index(){
      $users = DB::table('users')->get();
      $invoices = DB::table('invoices')
                  ->sum('total_price');
      $totalRev = DB::table('invoices')
                    ->select(DB::raw('Date(created_date) as date'), DB::raw('total_price as Views'))
                    ->groupBy(DB::raw('Date(created_date)'))
                    ->orderBy(DB::raw('Date(created_date)'))
                    ->get();

      $totalView = DB::table('invoices')
                    ->select(DB::raw('Date(created_date) as date'), DB::raw('count(*) as Views'))
                    ->groupBy(DB::raw('Date(created_date)'))
                    ->orderBy(DB::raw('Date(created_date)'))
                    ->get();
      return view('main',['invoices'=>$invoices,'totalRev'=>$totalRev,'totalView'=>$totalView]);
    }

    public function analytics(){
      $users = DB::table('users')->get();
      $invoices = DB::table('invoices')
                  ->sum('total_price');
      $totalRev = DB::table('invoices')
                    ->select(DB::raw('Date(created_date) as date'), DB::raw('total_price as Views'))
                    ->groupBy(DB::raw('Date(created_date)'))
                    ->orderBy(DB::raw('Date(created_date)'))
                    ->get();

      $totalView = DB::table('invoices')
                    ->select(DB::raw('Date(created_date) as date'), DB::raw('count(*) as Views'))
                    ->groupBy(DB::raw('Date(created_date)'))
                    ->orderBy(DB::raw('Date(created_date)'))
                    ->get();
      return view('main',['invoices'=>$invoices,'totalRev'=>$totalRev,'totalView'=>$totalView]);
      return view('analytics',['invoices'=>$invoices,'totalRev'=>$totalRev,'totalView'=>$totalView]);
    }


}
