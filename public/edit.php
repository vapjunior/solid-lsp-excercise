<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$id = (int)($_GET['id'] ?? 0);
$passage = $service->find($id);
if (!$passage) {
    http_response_code(404);
    echo '<!doctype html><meta charset="utf-8">Registro não encontrado. <a href="index.php">Voltar</a>';
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Editar Registro #<?= $passage->id() ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-3xl mx-auto p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Editar Registro #<?= $passage->id() ?></h1>
      <a href="index.php" class="text-blue-700 hover:underline">Voltar</a>
    </header>

    <div class="bg-white shadow rounded-xl p-6">
      <form method="post" action="update.php" class="space-y-5">
        <input type="hidden" name="id" value="<?= $passage->id() ?>" />

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Placa</label>
          <input name="plate" value="<?= htmlspecialchars($passage->plate()) ?>" required
                 class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Veículo</label>
          <select name="vehicle_type" required
                  class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
            <?php foreach (['car','truck','motorcycle','bus'] as $t): ?>
              <option value="<?= $t ?>" <?= $t === $passage->vehicleType() ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Eixos</label>
            <input name="axles" type="number" min="0" value="<?= $passage->axles() ?>" required
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tarifa Base (R$)</label>
            <input name="base_rate" type="number" step="0.01" min="0" value="<?= $passage->baseRate() ?>" required
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Quando (ISO 8601)</label>
            <input name="occurred_at" value="<?= htmlspecialchars($passage->occurredAt()) ?>"
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="inline-flex items-center rounded-lg bg-amber-500 text-white px-5 py-2.5 hover:bg-amber-600">
            Atualizar
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
