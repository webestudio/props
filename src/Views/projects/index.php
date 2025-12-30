<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-secondary tracking-tight">Proyectos</h1>
        <p class="text-gray-500 mt-1 font-medium italic">Gestión de proyectos y seguimiento de progreso</p>
    </div>
    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
        <!-- Search Form -->
        <form action="/projects" method="GET" class="relative flex-1 md:w-64">
            <input type="text" name="search" value="<?= h($search) ?>" placeholder="Buscar por nombre..."
                class="input-standard pl-10 h-10 text-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="hidden" name="per_page" value="<?= h($per_page) ?>">
        </form>

        <a href="/projects/create" class="btn btn-primary h-10 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Proyecto
        </a>
    </div>
</div>

<div class="card overflow-hidden shadow-xl border-0">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Proyecto
                    </th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Estado
                    </th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Progreso
                    </th>
                    <th
                        class="px-8 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest text-[10px]">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <?php if (empty($projects)): ?>
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            No se encontraron proyectos.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($projects as $project):
                    $tasks = $project->tasks();
                    $totalTasks = count($tasks);
                    $completedTasks = count(array_filter($tasks, fn($t) => $t->status === 'completed'));
                    $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    ?>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="font-bold text-secondary text-lg"><?= h($project->name) ?></div>
                            <?php if ($project->description): ?>
                                <div class="text-sm text-gray-400 font-medium mt-0.5 mt-1">
                                    <?= h(substr($project->description, 0, 80)) ?>
                                    <?= strlen($project->description) > 80 ? '...' : '' ?>
                                </div>
                            <?php endif; ?>
                            <div class="text-[10px] text-gray-300 uppercase tracking-tighter mt-1 font-black">
                                Creado: <?= formatDate($project->created_at) ?>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <?php
                            $statusColors = [
                                'active' => 'bg-primary bg-opacity-10 text-primary',
                                'completed' => 'bg-special bg-opacity-10 text-special',
                                'cancelled' => 'bg-red-50 text-red-600'
                            ];
                            $statusLabels = [
                                'active' => 'Activo',
                                'completed' => 'Completado',
                                'cancelled' => 'Cancelado'
                            ];
                            ?>
                            <span
                                class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full <?= $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800' ?>">
                                <?= $statusLabels[$project->status] ?? $project->status ?>
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-gray-100 rounded-full h-2 w-32 overflow-hidden">
                                    <div class="bg-primary h-full transition-all duration-700"
                                        style="width: <?= $percentage ?>%"></div>
                                </div>
                                <span class="text-xs font-black text-secondary"><?= $percentage ?>%</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <a href="/projects/edit?id=<?= $project->id ?>"
                                    class="p-2 text-primary hover:bg-primary hover:text-white rounded-lg transition-all shadow-sm shadow-primary/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="/projects/delete?id=<?= $project->id ?>"
                                    onclick="return confirm('¿Eliminar este proyecto?')"
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
    </div>

    <!-- Pagination Footer -->
    <div
        class="bg-gray-50/50 px-8 py-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4 text-xs font-bold text-gray-500 uppercase tracking-widest">
            <div class="flex items-center gap-2">
                <span>Ver:</span>
                <select
                    onchange="window.location.href='/projects?search=<?= urlencode($search) ?>&per_page=' + this.value"
                    class="bg-white border border-gray-200 rounded px-2 py-1 focus:ring-1 focus:ring-primary outline-none">
                    <?php foreach (['10', '30', '50', '100', 'all'] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page == $opt ? 'selected' : '' ?>>
                            <?= $opt === 'all' ? 'Todos' : $opt ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <span>Total: <?= $pagination['total'] ?> proyectos</span>
        </div>

        <?php if ($pagination['pages'] > 1): ?>
            <ul class="flex items-center gap-1">
                <?php if ($pagination['current_page'] > 1): ?>
                    <li>
                        <a href="/projects?page=<?= $pagination['current_page'] - 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
                            class="p-2 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
                    <li>
                        <a href="/projects?page=<?= $i ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all <?= $i == $pagination['current_page'] ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:bg-gray-100' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagination['current_page'] < $pagination['pages']): ?>
                    <li>
                        <a href="/projects?page=<?= $pagination['current_page'] + 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $per_page ?>"
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