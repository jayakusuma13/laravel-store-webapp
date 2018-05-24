<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function index(){
      $users = DB::table('users')->get();
      $invoices = DB::table('invoices')
                  ->sum('total_price');
      return view('welcome',['invoices'=>$invoices]);

    }
}
