<?php

namespace App;
use App\Contracts\HasMake as HasMakeContract;
use App\Contracts\HasModel as HasModelContract;
use App\Contracts\HasModelYear as HasModelYearContract;
use App\Contracts\HasVehicle as HasVehicleContract;
use App\Contracts\Vehicle as VehicleContract;
//use App\Traits\HasMake;
//use App\Traits\HasModel;
//use App\Traits\HasModelYear;
//use App\Traits\HasVehicle;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model implements VehicleContract
{
//    use HasMake, HasModel, HasModelYear;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_make_id',
        'vehicle_model_id',
        'vehicle_year_id',
        'name',
        'displacement',
        'drive',
        'transmission',
        'price'
    ];

    /**
     * Boot function for using with User Events.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            if ( ! $model->name) $model->attributes['name'] = $model->generateVehicleName();
        });
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

    /**
     * Scope by model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $model Model id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByModel($query, $model)
    {
        return $query->where('vehicle_model_id', $model);
    }

    /**
     * Scope by year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year Year id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('vehicle_year_id', $year);
    }

    /**
     * Generate vehicle name.
     *
     * @param string $format
     * @return string
     */
    public function generateVehicleName($format = "{transmission}, {drive}, {cylinders} cyl, {displacement}L")
    {
        preg_match_all("/{([^}]*)}/", $format, $placeholders);

        $replace = [];

        foreach ($placeholders[0] as $key => $value)
        {
            $replace[$value] = $this->attributes[$placeholders[1][$key]];
        }

        return str_replace(array_keys($replace), array_values($replace), $format);
    }

    /**
     * Vehicle belongs to one make.
     *
     * @return mixed
     */
    public function make() {
        return $this->belongsTo(VehicleMake::class);
    }

    /**
     * Vehicle belongs to one model.
     *
     * @return mixed
     */
    public function model() {
        return $this->belongsTo(VehicleModel::class);
    }

    /**
     * Vehicle belongs to one year.
     *
     * @return mixed
     */
    public function year() {
        return $this->belongsTo(VehicleModelYear::class);
    }

    /**
     * Vehicle has many offers.
     *
     * @return mixed
     */
    public function offers()
    {
        return $this->hasMany(VehicleOffer::class);
    }
}
