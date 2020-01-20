<?php

namespace App\Http\Controllers\API;

use App\Helpers\ServerLoad;
use App\Models\Log;
use App\Models\Procedure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getResponseTime()
    {
        $count = Procedure::count();
        $limit = $count * 10;
        $logs = Log::orderBy('id', 'desc')->limit($limit)->get();

        $timeList = [];
        $time = 0;
        $pos = 0;

        foreach ($logs as $index => $log) {
            $time += $log->response_time;
            $pos++;
            if ($pos === $count) {
                array_push($timeList, round($time, 2));
                $time = 0;
                $pos = 0;
            }
        }
        $timeList = array_reverse($timeList);
        return $timeList;
    }

    public function getCurrentErrors()
    {
        $count = Procedure::count();
        $logs = Log::orderBy('id', 'desc')->limit($count)->get();
        $errorList = [];

        foreach ($logs as $log) {
            if (substr($log->code, 0, $log->code < 0 ? 2 : 1) != 2) {
                array_push($errorList, $log);
            }
        }

        return $errorList;
    }

    public function getErrorsWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        return DB::table('logs')
            ->where('logs.status', 'LIKE', false)
            ->whereBetween('logs.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();
    }

    public function getChecksToday()
    {
        return DB::table('logs')
            ->whereDate('logs.created_at', Carbon::today())->get();
    }

    public function getLastKnownError()
    {
        return Log::where('logs.status', false)->orderBy('created_at', 'desc')->first();
    }

    public function getServerLoad()
    {
        return Cache::remember('serverLoad', now()->addSeconds(3), static function () {
            return ServerLoad::get();
        });
    }
}
