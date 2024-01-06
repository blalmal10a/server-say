<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignUserRolesAndPermissions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $roles;
    /**
     * Create a new job instance.
     */
    public function __construct($userId, $roles)
    {
        $this->userId = $userId;
        $this->roles = $roles;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::find($this->userId);
            $user->assignRole($this->roles);

            foreach ($user->roles as $role) {
                $permissions = $role->permissions;

                $permissionNames = array_map(function ($permission) {
                    return $permission->name;
                }, json_decode($permissions));

                $user->givePermissionTo($permissionNames);
            }
        } catch (\Throwable $th) {
            info('ERROR ON ASSIGNING ROLES AND PERMISSIONS FOR USER_ID: ' . $this->userId);
            info($th->getMessage());
        }
    }
}
