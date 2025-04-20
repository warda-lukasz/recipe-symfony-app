<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class MealDbApiErrorException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('An error occurred while fetching data from the MealDb API');
    }
}
