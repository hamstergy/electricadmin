<?php

namespace App;

use App\Traits\Excludable;
use Illuminate\Database\Eloquent\Model as Model;

class ElectricVehicle extends Model
{
    use Excludable;
    protected $table = 'electric_vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'imageSlug',
        'make',
        'model',
        'isConcept',
        'releaseDate',
        'acceleration',
        'speed',
        'range',
        'efficiency',
        'chargeSpeed',
        'battery',
        'price',
        'drive',
        'type',
        'segment',
        'seats',
        'description',
        'youtube'
    ];
}
