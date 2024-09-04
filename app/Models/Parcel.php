<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Picqer\Barcode\BarcodeGeneratorPNG;

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
        'forwarder_number',
        'barcode',
        'barcode_image',
    ];

    protected $casts = [
        'sending_date' => 'datetime',
        'estimated_delivery_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($parcel) {
            TrackingUpdate::create([
                'parcel_id' => $parcel->id,
                'status' => 'KTM Nepal Logistics',
                'location' => $parcel->location ?? '',
                'description' => $parcel->description,
                'tracking_number' => $parcel->tracking_number,
            ]);
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

public static function boot()
{
    parent::boot();

    static::creating(function ($parcel) {
        if (empty($parcel->tracking_number)) {
            $parcel->tracking_number = static::generateTrackingNumber();
        }

        $generator = new BarcodeGeneratorPNG();
        $barcode = $parcel->tracking_number;
        $parcel->barcode = $barcode;
        $parcel->barcode_image = base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128));
    });
}
}
