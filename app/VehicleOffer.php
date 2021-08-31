<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleOffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'type', 'displayType', 'end_date', 'disclaimers', 'offer_data'
    ];

    /**
     * Offer belongs to one vehicle.
     *
     * @return mixed
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
