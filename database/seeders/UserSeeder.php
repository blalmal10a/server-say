<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'BD',
                'phone' => '1',
                'corp_id' => 0,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Leader',
                'phone' => 1 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Assistant Leader',
                'phone' => 2 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Secretary',
                'phone' => 3 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Assistant Secretary',
                'phone' => 4 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Treasurer',
                'phone' => 5 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Assistant Treasurer',
                'phone' => 6 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Evangelism Incharge',
                'phone' => 7 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Member 1',
                'phone' => 8 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'name' => 'Member 3',
                'phone' => 9 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'name' => 'Member 3',
                'phone' => 10 + 1,
                'corp_id' => 1,
                'password' => Hash::make('Kurkur3;'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];


        DB::table('users')->insert($users);

        $users = User::all();
        foreach ($users as $user) {
            if ($user->id == 1) continue;
            if ($user->id - 1 == 8) {
                $designations = [8];
            } else {
                $designations = [
                    $user->id - 1,
                    8
                ];
            }
            $user->designations()->attach($designations);
        }
    }
}
