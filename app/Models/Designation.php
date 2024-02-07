<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// // use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;


class Designation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'desgination_user', 'designation_id', 'user_id');
    }
}
