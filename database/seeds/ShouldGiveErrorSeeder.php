<?php

use App\Enums\FieldType;
use App\Enums\ProcedureType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShouldGiveErrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding instance
        DB::table('instances')->insert([
            'id' => 2,
            'name' => 'Should error instance',
            'logo' => 'logo.png',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_id' => 1
        ]);

        //adding endpoints
        DB::table('endpoints')->insert([
            'name' => 'Request error endpoint',
            'url' => 'https://leaseplan.space-lms.com/',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'instance_id' => 2
        ]);
        DB::table('endpoints')->insert([
            'name' => 'Body error endpoint',
            'url' => 'http://webtraders.nl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'instance_id' => 2
        ]);

        //adding procedures
        DB::table('procedures')->insert([
            'type' => ProcedureType::REQUEST,
            'interval' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'endpoint_id' => 3
        ]);
        DB::table('procedures')->insert([
            'type' => ProcedureType::BODY,
            'interval' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'endpoint_id' => 4
        ]);

        //adding fields
        DB::table('fields')->insert([
            'type' => FieldType::TEXT,
            'handle' => 'body',
            'value' => 'Should give error.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'procedure_id' => 4
        ]);
    }
}
