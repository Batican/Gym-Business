<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date_for_checking',
        'url',
        'qr_value',

       
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
