<?php

namespace App\Console\Commands;

use App\Events\SyncChanged;
use App\Models\Instance;
use App\Models\Log;
use App\Services\InstanceService;
use Illuminate\Console\Command;

class ProcessMain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:main';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the entire process of running every procedure of every endpoint of every instance.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        event(new SyncChanged(true));
        foreach (Instance::all() as $instance) {
            $instancedService = new InstanceService($instance);
            $instancedService->process();
        }

        event(new SyncChanged(false));

        $this->removeOldLogs();
        return;
    }

    private function removeOldLogs() {
        $date = new \DateTime;
        $date->modify('-1 days');
        $formatted = $date->format('Y-m-d H:i:s');
        Log::where([
            ['created_at', '<=', $formatted],
            ['status', '=', true]
            ])->delete();
    }
}
