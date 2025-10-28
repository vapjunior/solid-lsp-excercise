<?php
declare(strict_types=1);

namespace App\Domain;

interface PassageRepository
{
    /** @return Passage[] */
    public function all(): array;

    public function find(int $id): ?Passage;

    public function create(Passage $p): Passage;

    public function update(Passage $p): void;

    public function delete(int $id): void;
}
