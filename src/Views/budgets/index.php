<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-secondary">Presupuestos</h1>
        <p class="text-gray-600 mt-2">Gestión de presupuestos</p>
    </div>
    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
        <!-- Search Form -->
        <form action="/budgets" method="GET" class="relative flex-1 md:w-64">
            <input type="text" name="search" value="<?= h($search) ?>" placeholder="Buscar presupuesto..."
                class="input-standard pl-10 h-10 text-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="hidden" name="per_page" value="<?= h($per_page) ?>">
        </form>

        <a href="/budgets/create" class="btn btn-primary h-10 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Presupuesto
        </a>
    </div>
</div>

<div class="card overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Válido hasta
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (empty($budgets)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        No se encontraron presupuestos.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($budgets as $budget): ?>
                <?php $project = $budget->project(); ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-secondary"><?= h($budget->title) ?></div>
                        <?php if ($budget->description): ?>
                            <div class="text-sm text-gray-500">
                                <?= h(substr($budget->description, 0, 40)) ?>
                                <?= strlen($budget->description) > 40 ? '...' : '' ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        <?= $project ? h($project->name) : '-' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800',
                            'sent' => 'bg-primary bg-opacity-10 text-primary',
                            'approved' => 'bg-special bg-opacity-10 text-special',
                            'rejected' => 'bg-red-50 text-red-600'
                        ];
                        $statusLabels = [
                            'draft' => 'Borrador',
                            'sent' => 'Enviado',
                            'approved' => 'Aprobado',
                            'rejected' => 'Rechazado'
                        ];
                        ?>
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-lg <?= $statusColors[$budget->status] ?? 'bg-gray-100 text-gray-800' ?>">
                            <?= $statusLabels[$budget->status] ?? $budget->status ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-secondary">
                        <?= formatCurrency($budget->total) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <?= formatDate($budget->valid_until) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex justify-end gap-3">
                            <a href="/budgets/edit?id=<?= $budget->id ?>"
                                class="p-2 text-primary hover:bg-primary hover:text-white rounded-lg transition-all shadow-sm shadow-primary/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="/budgets/delete?id=<?= $budget->id ?>"
                                onclick="return confirm('¿Eliminar este presupuesto?')"
                                class="p-2 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-all shadow-sm shadow-red-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Footer -->
    <div
        class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4 text-xs font-bold text-gray-500 uppercase tracking-widest">
            <div class="flex items-center gap-2">
                <span>Ver:</span>
                <select
                    onchange="window.location.href='/budgets?search=<?= urlencode($search) ?>&per_page=' + this.value"
                    class="bg-white border border-gray-200 rounded px-2 py-1 focus:ring-1 focus:ring-primary outline-none text-gray-600">
                    <?php foreach (['10', '30', '50', '100', 'all'] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page == $opt ? 'selected' : '' ?>>
                            <?= $opt === 'all' ? 'Todos' : $opt ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <span>Total: <?= $pagination['total'] ?> presupuestos</span>
        </div>

        <?php if ($pagination['pages'] > 1): ?>
            <ul class="flex items-center gap-1">
                <?php if ($pagination['current_page'] > 1): ?>
                    <li>
                        <a href="/budgets?page=<?= $pagination['current_page'] - 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
                            class="p-2 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
                    <li>
                        <a href="/budgets?page=<?= $i ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all <?= $i == $pagination['current_page'] ? 'bg-primary text-white shadow-lg' : 'text-gray-400 hover:bg-gray-100' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagination['current_page'] < $pagination['pages']): ?>
                    <li>
                        <a href="/budgets?page=<?= $pagination['current_page'] + 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
                            class="p-2 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>