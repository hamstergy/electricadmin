<?php
namespace App\Contracts;
interface HasModelYear
{
    /**
     * Belongs to one model year.
     *
     * @return mixed
     */
    public function modelYear();
}
