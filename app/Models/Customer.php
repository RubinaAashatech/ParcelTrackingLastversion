<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'address',
        'phone_no',
        'email',
    ];

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}
