<?php
declare(strict_types=1);

namespace App\Domain\Policies;

use App\Domain\TollPolicy;

final class MotorcyclePolicy implements TollPolicy
{
    public function calculate(float $baseRate, int $axles): float
    {
        // Moto: desconto de 50% e eixos irrelevantes
        return $baseRate * 0.5;
    }
}
