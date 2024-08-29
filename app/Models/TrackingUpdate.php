<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'status',
        'location',
        'description',
        'notes',
        'tracking_number',
    ];
    

    /**
     * Get the parcel that owns the tracking update.
     */
    protected static function booted()
    {
        static::created(function ($trackingUpdate) {
            $parcel = Parcel::find($trackingUpdate->parcel_id);
            if ($parcel) {
                $parcel->trackingUpdates()->attach($trackingUpdate->id);
            }
        });

        static::updated(function ($trackingUpdate) {
            $parcel = Parcel::find($trackingUpdate->parcel_id);
            if ($parcel) {
                // Ensure pivot table reflects the latest update
                $parcel->trackingUpdates()->syncWithoutDetaching([$trackingUpdate->id]);
            }
        });

        static::deleted(function ($trackingUpdate) {
            $parcel = Parcel::find($trackingUpdate->parcel_id);
            if ($parcel) {
                $parcel->trackingUpdates()->detach($trackingUpdate->id);
            }
        });
    }

    // public function parcel()
    // {
    //     return $this->belongsToMany(Parcel::class, 'parcel_tracking_update');
    // }
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
    
}
