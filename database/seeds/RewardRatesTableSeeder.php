<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('reward_rates')->insert([
            'reward_convertion_rate' => 0.010,
            'over_total' => 100.00,
            'value' => 1.00,
        ]);
    }
}
