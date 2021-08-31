<?php

trait HasMake
{
    public function make()
    {
        return $this->belongsTo(config('app.VehicleMake'));
    }
}
