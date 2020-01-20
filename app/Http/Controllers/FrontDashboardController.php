<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class FrontDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('Dashboard/index');
    }

    /**
     * Show the application dashboard.
     *
     * @param Instance $instance
     * @return Renderable
     */
    public function endpoints(Instance $instance)
    {
        $instance->load('endpoints.procedures.logs')->toArray();
        return view('Dashboard/endpoints', compact('instance'));
    }
}
