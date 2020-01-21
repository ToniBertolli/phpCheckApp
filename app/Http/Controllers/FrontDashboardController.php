<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Models\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     * @throws \Exception
     */
    public function endpointErrors()
    {
        $date = new \DateTime;
        $date->modify('-2 days');
        $formatted = $date->format('Y-m-d H:i:s');

        $logs = Log::where([
                ['created_at', '>=', $formatted],
                ['status', '=', false]
            ])
            ->orderByDesc('created_at')
            ->with('procedure.endpoint')
            ->get();

        return view('Dashboard/endpointErrors', compact('logs'));
    }
}
