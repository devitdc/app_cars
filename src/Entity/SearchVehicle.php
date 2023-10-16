<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SearchVehicle
{
    /**
     * @Assert\LessThanOrEqual(propertyPath="maxYear", message="Doit être inférieur à l'année {{ compared_value }}.")
     */
    private $minYear;
    /**
     * @Assert\GreaterThanOrEqual(propertyPath="minYear", message="Doit être supérieur à l'année {{ compared_value }}.")
     */
    private $maxYear;

    public function getMinYear()
    {
        return $this->minYear;
    }

    public function setMinYear($minYear)
    {
        $this->minYear = $minYear;
        return $this->minYear;
    }

    public function getMaxYear()
    {
        return $this->maxYear;
    }

    public function setMaxYear($maxYear)
    {
        $this->maxYear = $maxYear;
        return $this->maxYear;
    }
}