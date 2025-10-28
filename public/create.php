<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Novo Registro de Pedágio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-3xl mx-auto p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Novo Registro</h1>
      <a href="index.php" class="text-blue-700 hover:underline">Voltar</a>
    </header>

    <div class="bg-white shadow rounded-xl p-6">
      <form method="post" action="store.php" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Placa</label>
          <input name="plate" placeholder="ABC-1234" required
                 class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Veículo</label>
          <select name="vehicle_type" required
                  class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="car">car</option>
            <option value="truck">truck</option>
            <option value="motorcycle">motorcycle</option>
            <option value="bus">bus</option>
          </select>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Eixos</label>
            <input name="axles" type="number" min="0" value="2" required
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tarifa Base (R$)</label>
            <input name="base_rate" type="number" step="0.01" min="0" value="10.00" required
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Quando (ISO 8601)</label>
            <input name="occurred_at" value="<?= htmlspecialchars(date('c')) ?>"
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="inline-flex items-center rounded-lg bg-blue-600 text-white px-5 py-2.5 hover:bg-blue-700">
            Salvar
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
