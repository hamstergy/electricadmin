<?php

namespace Gerardojbaez\Vehicle\Traits;

trait HasVehicle
{
    public function vehicle()
    {
        return $this->belongsTo(config('app.vehicle'));
    }
}
