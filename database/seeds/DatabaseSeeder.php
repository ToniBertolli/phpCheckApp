<?php

use App\Enums\ProcedureType;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'info@webtraders.nl',
            'password' => bcrypt('Admin123456'),
        ]);

        $this->call(WebtradersSeeder::class);
        $this->call(ShouldGiveErrorSeeder::class);




//        for($i=0; $i<3; $i++) {
//            DB::table('dashboards')->insert([
//                'name' => $faker->company,
//                'logo' => 'logo.png',
//            ]);
//
//            DB::table('domains')->insert([
//                'name' => Str::random(10),
//                'url' => 'http://'.Str::random(10).'.com',
//                'status' => true,
//                'dashboard_id' => $i+1,
//            ]);
//
//            DB::table('procedures')->insert([
//                'status' => true,
//                'code' => '200',
//                'domain_id' => $i+1,
//                'type' => ProcedureType::REQUEST(),
//            ]);
//        }
    }
}
