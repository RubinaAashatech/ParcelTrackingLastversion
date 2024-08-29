<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'previous_status',
        'new_status',
        'location',
        'description',
    ];

    /**
     * Get the parcel that owns the parcel history.
     */
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
