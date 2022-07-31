<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class ElectricBike extends Model
{
    protected $table = 'electric_bikes';

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
        'speed',
        'range',
        'description',
        'youtube',
        'price',
        'battery',
        'motor',
        'gears',
        'tire',
        'type',
        'weight',
        'folding',
        'break_system',
        'frame_type',
        'url',
        'amazon_id',
        'review_rate',
        'title'
    ];
}
