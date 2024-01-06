<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [ 'key' => 'app_name', 'value' => 'Lailen Template', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
        ];

        DB::table('settings')->insert($settings);
    }
}
