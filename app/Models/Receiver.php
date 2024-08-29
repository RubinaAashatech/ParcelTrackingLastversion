<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'country',
        'state',
        'city',
        'street_address',
        'postal_code',
        'phone_no',
        'email',
    ];

    public function getFullNameAttribute()
    {
        return $this->attributes['fullname'] ?? ''; 
    }
    
    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}
