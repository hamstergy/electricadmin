<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\VehicleModel as VehicleModelContract;

class VehicleModel extends Model implements VehicleModelContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'class', 'price', 'description', 'lease', 'finance', 'detail', 'image', 'slug', 'video', 'vehicle_make_id'
    ];

    /**
     * Model belongs to one make.
     *
     * @return mixed
     */
    public function make()
    {
        return $this->belongsTo(VehicleMake::class);
    }


    /**
     * Model has many years.
     *
     * @return mixed
     */
    public function years()
    {
        return $this->belongsTo(VehicleModelYear::class);
    }

    /**
     * Model has many years.
     *
     * @return mixed
     */
    public function vehicle()
    {
        return $this->HasOne(Vehicle::class);
    }

    /**
     * Scope by make.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $make Make id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMake($query, $make)
    {
        return $query->where('vehicle_make_id', $make);
    }
}
