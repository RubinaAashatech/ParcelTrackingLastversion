<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Parcel extends Model
{
    protected $fillable = [
        'tracking_number',
        'customer_id',
        'receiver_id',
        'carrier',
        'sending_date',
        'weight',
        'description',
        'estimated_delivery_date',
    ];

    protected $casts = [
        'sending_date' => 'datetime',
        'estimated_delivery_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($parcel) {
            // Create a default tracking update when a new parcel is created
            TrackingUpdate::create([
                'parcel_id' => $parcel->id,
                'status' => 'KTM Nepal Logistics',
                'location' => $parcel->location ?? '',
                'description' => $parcel->description,
                'tracking_number' => $parcel->tracking_number,
            ]);
        });

        static::creating(function ($parcel) {
            if (empty($parcel->tracking_number)) {
                $parcel->tracking_number = static::generateTrackingNumber();
            }
        });
    }

    protected static function generateTrackingNumber()
    {
        return str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }

    public function latestTrackingUpdate()
{
    return $this->hasOne(TrackingUpdate::class)->latest();
}

public function trackingUpdates()
{
    return $this->belongsToMany(TrackingUpdate::class, 'parcel_tracking_update');
}
}
