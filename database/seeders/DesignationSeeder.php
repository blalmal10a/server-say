<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            ['name' => 'Leader', 'order' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Assistant Leader', 'order' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Secretary', 'order' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Assistant Secretary', 'order' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Treasurer', 'order' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Assistant Treasurer', 'order' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Evangelism Incharge', 'order' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Member', 'order' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('designations')->insert($designations);
    }
}
