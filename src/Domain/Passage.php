<?php
declare(strict_types=1);

namespace App\Domain;

final class Passage
{
    public function __construct(
        private ?int $id,
        private string $plate,
        private string $vehicleType, // "car" | "truck" | "motorcycle" | "bus"
        private int $axles,
        private float $baseRate,
        private float $amount,
        private string $occurredAt // ISO 8601
    ) {}

    public function id(): ?int { return $this->id; }
    public function plate(): string { return $this->plate; }
    public function vehicleType(): string { return $this->vehicleType; }
    public function axles(): int { return $this->axles; }
    public function baseRate(): float { return $this->baseRate; }
    public function amount(): float { return $this->amount; }
    public function occurredAt(): string { return $this->occurredAt; }

    public function withId(int $id): self
    {
        return new self($id, $this->plate, $this->vehicleType, $this->axles, $this->baseRate, $this->amount, $this->occurredAt);
    }
}
