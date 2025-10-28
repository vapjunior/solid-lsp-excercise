<?php
declare(strict_types=1);

namespace App\Domain;

final class TollCalculator
{
    /** @var array<string,TollPolicy> */
    private array $policies = [];

    /** @param array<string,TollPolicy> $policies */
    public function __construct(array $policies)
    {
        $this->policies = $policies;
    }

    public function calculate(string $vehicleType, float $baseRate, int $axles): float
    {
        $key = strtolower($vehicleType);
        if (!isset($this->policies[$key])) {
            // fallback simples: sem bônus/alteração
            return max(0.0, $baseRate);
        }
        $amount = $this->policies[$key]->calculate($baseRate, $axles);
        return max(0.0, $amount);
    }

    /** @return string[] */
    public function supportedTypes(): array
    {
        return array_keys($this->policies);
    }
}
