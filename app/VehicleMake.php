<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;
use App\Contracts\VehicleMake as VehicleMakeContract;
use App\VehicleModel as VehicleModel;

class VehicleMake extends Model implements VehicleMakeContract
{

    protected $table = 'vehicle_makes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * Make has many models.
     *
     * @return mixed
     */
    public function models()
    {
        return $this->hasMany(VehicleModel::class);
    }
}
