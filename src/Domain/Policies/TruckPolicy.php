<?php
declare(strict_types=1);

namespace App\Domain\Policies;

use App\Domain\TollPolicy;

final class TruckPolicy implements TollPolicy
{
    public function calculate(float $baseRate, int $axles): float
    {
        // Caminhão: multiplicador por eixo total
        $axles = max(2, $axles);
        return $baseRate * $axles * 1.2;
    }
}
