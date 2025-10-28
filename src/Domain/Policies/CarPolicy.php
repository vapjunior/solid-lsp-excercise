<?php
declare(strict_types=1);

namespace App\Domain\Policies;

use App\Domain\TollPolicy;

final class CarPolicy implements TollPolicy
{
    public function calculate(float $baseRate, int $axles): float
    {
        // Carro padrão: tarifa base + pequeno acréscimo por eixo adicional
        $extra = max(0, $axles - 2) * 1.50;
        return $baseRate + $extra;
    }
}
