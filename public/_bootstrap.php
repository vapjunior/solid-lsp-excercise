<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\PassageService;
use App\Domain\PassageValidator;
use App\Domain\TollCalculator;
use App\Domain\Policies\CarPolicy;
use App\Domain\Policies\TruckPolicy;
use App\Domain\Policies\MotorcyclePolicy;
use App\Domain\Policies\BusPolicy;
use App\Infra\SqlitePassageRepository;

$pdo = new PDO('sqlite:' . __DIR__ . '/../storage/database.sqlite');

$calculator = new TollCalculator([
    'car' => new CarPolicy(),
    'truck' => new TruckPolicy(),
    'motorcycle' => new MotorcyclePolicy(),
    'bus' => new BusPolicy(),
]);

$repo = new SqlitePassageRepository($pdo);
$validator = new PassageValidator();
$service = new PassageService($repo, $validator, $calculator);
