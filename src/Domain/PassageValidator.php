<?php
declare(strict_types=1);

namespace App\Domain;

final class PassageValidator
{
    /**
     * @param array{
     *   plate?:string,
     *   vehicle_type?:string,
     *   axles?:string|int,
     *   base_rate?:string|float,
     *   occurred_at?:string
     * } $input
     * @return string[]
     */
    public function validate(array $input): array
    {
        $errors = [];

        $plate = strtoupper(trim((string)($input['plate'] ?? '')));
        $vt = strtolower(trim((string)($input['vehicle_type'] ?? '')));
        $axles = (int)($input['axles'] ?? -1);
        $base = (float)($input['base_rate'] ?? -1);
        $when = (string)($input['occurred_at'] ?? date('c'));

        if ($plate === '' || !preg_match('/^[A-Z0-9-]{5,10}$/', $plate)) {
            $errors[] = 'Placa inválida (use letras/números e hífen, 5-10 chars).';
        }

        $allowed = ['car','truck','motorcycle','bus'];
        if (!in_array($vt, $allowed, true)) {
            $errors[] = 'Tipo de veículo inválido (car/truck/motorcycle/bus).';
        }

        if (!is_numeric($input['axles'] ?? null) || $axles < 0) {
            $errors[] = 'Eixos devem ser inteiros e >= 0.';
        }

        if (!is_numeric($input['base_rate'] ?? null) || $base < 0) {
            $errors[] = 'Tarifa base deve ser numérica e >= 0.';
        }

        // Validação simples de data/hora (ISO 8601)
        if (\DateTime::createFromFormat(\DateTime::ATOM, $when) === false) {
            $errors[] = 'Data/Hora inválida (use ISO 8601, ex: '.date('c').').';
        }

        return $errors;
    }
}
