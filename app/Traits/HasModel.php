<?php

trait HasModel
{
    public function model()
    {
        return $this->belongsTo(config('app.VehicleModel'));
    }
}
