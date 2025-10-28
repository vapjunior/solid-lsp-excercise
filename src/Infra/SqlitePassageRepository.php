<?php
declare(strict_types=1);

namespace App\Infra;

use App\Domain\Passage;
use App\Domain\PassageRepository;
use PDO;

final class SqlitePassageRepository implements PassageRepository
{
    public function __construct(private PDO $pdo)
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** @return Passage[] */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM passages ORDER BY id DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        return array_map([$this, 'mapRow'], $rows);
    }

    public function find(int $id): ?Passage
    {
        $stmt = $this->pdo->prepare('SELECT * FROM passages WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ? $this->mapRow($r) : null;
    }

    public function create(Passage $p): Passage
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO passages (plate, vehicle_type, axles, base_rate, amount, occurred_at)
             VALUES (:plate, :vehicle_type, :axles, :base_rate, :amount, :occurred_at)'
        );
        $stmt->execute([
            ':plate' => $p->plate(),
            ':vehicle_type' => $p->vehicleType(),
            ':axles' => $p->axles(),
            ':base_rate' => $p->baseRate(),
            ':amount' => $p->amount(),
            ':occurred_at' => $p->occurredAt(),
        ]);
        $id = (int)$this->pdo->lastInsertId();
        return $p->withId($id);
    }

    public function update(Passage $p): void
    {
        if ($p->id() === null) {
            throw new \InvalidArgumentException('ID obrigatório para update.');
        }
        $stmt = $this->pdo->prepare(
            'UPDATE passages
             SET plate=:plate, vehicle_type=:vehicle_type, axles=:axles, base_rate=:base_rate, amount=:amount, occurred_at=:occurred_at
             WHERE id=:id'
        );
        $stmt->execute([
            ':id' => $p->id(),
            ':plate' => $p->plate(),
            ':vehicle_type' => $p->vehicleType(),
            ':axles' => $p->axles(),
            ':base_rate' => $p->baseRate(),
            ':amount' => $p->amount(),
            ':occurred_at' => $p->occurredAt(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM passages WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    /** @param array<string,mixed> $r */
    private function mapRow(array $r): Passage
    {
        return new Passage(
            id: (int)$r['id'],
            plate: (string)$r['plate'],
            vehicleType: (string)$r['vehicle_type'],
            axles: (int)$r['axles'],
            baseRate: (float)$r['base_rate'],
            amount: (float)$r['amount'],
            occurredAt: (string)$r['occurred_at']
        );
    }
}
