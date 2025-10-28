<?php
declare(strict_types=1);

namespace App\Domain\Policies;

use App\Domain\TollPolicy;

final class BusPolicy implements TollPolicy
{
    public function calculate(float $baseRate, int $axles): float
    {
        // Ônibus: base + taxa fixa + 0,75 por eixo acima de 2
        $extra = max(0, $axles - 2) * 0.75;
        return $baseRate + 2.50 + $extra;
    }
}
