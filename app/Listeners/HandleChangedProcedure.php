<?php

namespace App\Listeners;

use App\Events\ProcedureChanged;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleChangedProcedure
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcedureChanged  $event
     * @return void
     */
    public function handle(ProcedureChanged $event)
    {
        //$this->updateEndpointStatus($event);
    }
//
//    private function updateEndpointStatus($event)
//    {
//        $event->procedure->endpoint->update([
//            'status' => $event->procedure->status
//        ]);
//    }
}
