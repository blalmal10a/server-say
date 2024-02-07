<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'Member 2',
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

        $member_designation_id = null;

        for ($i = 0; $i < sizeof($users); $i++) {
            $user = User::create($users[$i]);
            if ($i == 0) continue;
            if (isset($designations[$i - 1])) {
                $user->designations()->create($designations[$i - 1]);
            } else {
                if (!$member_designation_id) {
                    $member_designation_id = Designation::where('name', 'like', 'Member')->first();
                } else {
                    $user->designations;
                    $user->designations()->save($member_designation_id);
                }
            }
        }

        $user_collection = User::all();
        $counter = 1;
        foreach ($user_collection as $user) {
            if ($counter == 8) break;
            $user->designations()->save($member_designation_id);
        }
    }
}
