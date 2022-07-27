<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fee',
       
    ];

    public function subscription()
    {
        return $this->hasOne(
            Subsctiption::class, 
            'membership_id'
        );
    }
}
