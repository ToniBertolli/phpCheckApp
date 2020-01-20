<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instance;
use App\Models\Endpoint;
use App\Models\Procedure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminViewsController extends Controller
{
    protected $rules = [
        'name' => 'required',
        'logo' => 'nullable',
        'user_id' => 'sometimes'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function instances()
    {
        $instances = Instance::where('user_id', auth()->id())->get();
        return view('Admin.instances', compact('instances'));
    }

    /**
     * Show the application dashboard.
     *
     * @param Instance $instance
     * @return Renderable
     */
    public function instance(Instance $instance)
    {
        return view('Admin.instance', compact('instance'));
    }

    /**
     * Show the application dashboard.
     *
     * @param Instance $instance
     * @param Endpoint $endpoint
     * @return Renderable
     */
    public function endpoint(Instance $instance, Endpoint $endpoint)
    {
        return view('Admin.endpoint', compact('endpoint'));
    }
}
