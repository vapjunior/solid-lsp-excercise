<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\Passage;
use App\Domain\PassageRepository;
use App\Domain\PassageValidator;
use App\Domain\TollCalculator;

final class PassageService
{
    public function __construct(
        private PassageRepository $repo,
        private PassageValidator $validator,
        private TollCalculator $calculator
    ) {}

    /**
     * @param array{
     *   plate?:string, vehicle_type?:string, axles?:string|int,
     *   base_rate?:string|float, occurred_at?:string
     * } $input
     * @return array{ok:bool, errors?:string[], id?:int}
     */
    public function create(array $input): array
    {
        $errors = $this->validator->validate($input);
        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors];
        }

        $plate = strtoupper(trim((string)$input['plate']));
        $vt = strtolower(trim((string)$input['vehicle_type']));
        $axles = (int)$input['axles'];
        $base = (float)$input['base_rate'];
        $when = (string)($input['occurred_at'] ?? date('c'));

        $amount = $this->calculator->calculate($vt, $base, $axles);

        $passage = new Passage(
            id: null,
            plate: $plate,
            vehicleType: $vt,
            axles: $axles,
            baseRate: $base,
            amount: $amount,
            occurredAt: $when
        );

        $created = $this->repo->create($passage);
        return ['ok' => true, 'id' => $created->id()];
    }

    /**
     * @param array{
     *   plate?:string, vehicle_type?:string, axles?:string|int,
     *   base_rate?:string|float, occurred_at?:string
     * } $input
     * @return array{ok:bool, errors?:string[]}
     */
    public function update(int $id, array $input): array
    {
        $existing = $this->repo->find($id);
        if (!$existing) {
            return ['ok' => false, 'errors' => ['Passagem não encontrada.']];
        }

        $errors = $this->validator->validate($input);
        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors];
        }

        $plate = strtoupper(trim((string)$input['plate']));
        $vt = strtolower(trim((string)$input['vehicle_type']));
        $axles = (int)$input['axles'];
        $base = (float)$input['base_rate'];
        $when = (string)($input['occurred_at'] ?? date('c'));

        $amount = $this->calculator->calculate($vt, $base, $axles);

        $updated = new Passage(
            id: $id,
            plate: $plate,
            vehicleType: $vt,
            axles: $axles,
            baseRate: $base,
            amount: $amount,
            occurredAt: $when
        );

        $this->repo->update($updated);
        return ['ok' => true];
    }

    public function delete(int $id): array
    {
        $existing = $this->repo->find($id);
        if (!$existing) {
            return ['ok' => false, 'errors' => ['Passagem não encontrada.']];
        }
        $this->repo->delete($id);
        return ['ok' => true];
    }

    /** @return Passage[] */
    public function all(): array
    {
        return $this->repo->all();
    }

    public function find(int $id): ?Passage
    {
        return $this->repo->find($id);
    }
}
