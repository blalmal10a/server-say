<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class FaithPromise extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function members()
    {
        return $this->belongsToMany(User::class);
        // return $this->belongsToMany(User::class, 'faith_promise_user', 'faith_promise_id', 'user_id',);
    }

    // public function details()
    // {
    //     return $this->hasMany(MemberPayment::class, 'payable_id', 'id');
    // }

    public function details()
    {
        return $this->hasMany(FaithPromisePayment::class, 'faith_promise_id', '_id');
        // return $this->morphMany(MemberPayment::class, 'payable');
    }
}
