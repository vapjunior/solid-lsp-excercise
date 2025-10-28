<?php
declare(strict_types=1);

namespace App\Domain;

interface TollPolicy
{
    public function calculate(float $baseRate, int $axles): float;
}
