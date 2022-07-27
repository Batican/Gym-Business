<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone_number',
        'gender',
        'age',
        'email',
        'subscription_id',
    ];

    public function payments()
    {
        return $this->hasMany(
            Payment::class, 
            'customer_id'
        );
    }

    public function subscription()
    {
        return $this->hasOne(
            Subsctiption::class, 
            'customer_id'
        );
    }

      public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
