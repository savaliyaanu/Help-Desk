<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $year = DB::select("SELECT
	CONCAT(
		RIGHT (YEAR(date_from), 4),
		'-',
		RIGHT (YEAR(date_to), 4)
	) as year
FROM
	financial_year ");
        return view('home')->with(compact('year'));
    }
}
