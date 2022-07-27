<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    const Paid = 1;
    const Unpaid = 2;   

    use HasFactory;

    protected $fillable = [
        'membership_id',
        'start_date',
        'end_date',
        'customer_id',
        'total',
        'status'
       
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
