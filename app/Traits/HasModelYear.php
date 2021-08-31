<?php

namespace Gerardojbaez\Vehicle\Traits;

trait HasModelYear
{
    public function year()
    {
        return $this->belongsTo(config('app.VehicleYear'));
    }
}
