<?php
namespace App\Contracts;
interface HasVehicle
{
    /**
     * Belongs to one vehicle.
     *
     * @return mixed
     */
    public function vehicle();
}
