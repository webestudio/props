<div class="mb-6">
    <h1 class="text-3xl font-bold text-secondary">Dashboard</h1>
    <p class="text-gray-600 mt-2">Bienvenido, <?= h(auth()->name) ?></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stats cards -->
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Clientes</p>
                <p class="text-3xl font-bold text-secondary mt-2">
                    <?= $stats['clients'] ?>
                </p>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Proyectos</p>
                <p class="text-3xl font-bold text-secondary mt-2">
                    <?= $stats['projects'] ?>
                </p>
            </div>
            <div class="bg-special bg-opacity-10 p-3 rounded-lg">
                <svg class="w-8 h-8 text-special" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Presupuestos</p>
                <p class="text-3xl font-bold text-secondary mt-2">
                    <?= $stats['budgets'] ?>
                </p>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tareas Pendientes</p>
                <p class="text-3xl font-bold text-secondary mt-2">
                    <?= $stats['pending_tasks'] ?>
                </p>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-lg">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick actions -->
<div class="mt-8 card p-6">
    <h2 class="text-xl font-bold text-secondary mb-4">Acciones Rápidas</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/clients/create"
            class="flex items-center gap-4 p-5 bg-global border border-white border-opacity-10 rounded-2xl hover:border-primary hover:bg-white hover:shadow-xl transition-all duration-300 group">
            <div class="p-3 bg-primary bg-opacity-10 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <span class="block font-black text-secondary">Nuevo Cliente</span>
                <span class="text-xs text-gray-500 font-medium">Registrar prospecto</span>
            </div>
        </a>

        <a href="/projects/create"
            class="flex items-center gap-4 p-5 bg-global border border-white border-opacity-10 rounded-2xl hover:border-special hover:bg-white hover:shadow-xl transition-all duration-300 group">
            <div class="p-3 bg-special bg-opacity-10 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-special" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <span class="block font-black text-secondary">Nuevo Proyecto</span>
                <span class="text-xs text-gray-500 font-medium">Iniciar trabajo</span>
            </div>
        </a>

        <a href="/budgets/create"
            class="flex items-center gap-4 p-5 bg-global border border-white border-opacity-10 rounded-2xl hover:border-primary hover:bg-white hover:shadow-xl transition-all duration-300 group">
            <div class="p-3 bg-primary bg-opacity-10 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <span class="block font-black text-secondary">Nuevo Presupuesto</span>
                <span class="text-xs text-gray-500 font-medium">Enviar propuesta</span>
            </div>
        </a>
    </div>
</div>

<!-- Recent Activity Columns -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Projects Column -->
    <div class="card p-6">
        <h2 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-special" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            Últimos Proyectos
        </h2>
        <div class="divide-y divide-gray-100">
            <?php foreach ($latestProjects as $p): ?>
                <a href="/projects/edit?id=<?= $p->id ?>" class="block py-3 hover:bg-gray-50 transition-colors">
                    <div class="font-bold text-gray-800 text-sm truncate" title="<?= h($p->name) ?>"><?= h($p->name) ?>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span
                            class="text-[10px] text-gray-400 font-black uppercase tracking-tighter"><?= formatDate($p->created_at) ?></span>
                        <span
                            class="text-[9px] px-2 py-0.5 rounded-full font-black uppercase bg-primary bg-opacity-10 text-primary">
                            <?= h($p->status) ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (empty($latestProjects)): ?>
                <p class="py-4 text-sm text-gray-400 text-center">No hay proyectos recientes</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tasks Column -->
    <div class="card p-6">
        <h2 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Últimas Tareas
        </h2>
        <div class="divide-y divide-gray-100">
            <?php foreach ($latestTasks as $t): ?>
                <div class="py-3">
                    <div class="font-bold text-gray-800 text-sm truncate" title="<?= h($t->title) ?>"><?= h($t->title) ?>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-[10px] text-gray-400 font-black tracking-tighter truncate max-w-[150px]"
                            title="<?= ($proj = $t->project()) ? h($proj->name) : 'S/P' ?>">
                            <?= ($proj = $t->project()) ? h($proj->name) : 'S/P' ?>
                        </span>
                        <span
                            class="text-[9px] px-2 py-0.5 rounded-full font-black uppercase <?= $t->status === 'completed' ? 'bg-special bg-opacity-10 text-special' : 'bg-yellow-50 text-yellow-600' ?>">
                            <?= h($t->status) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($latestTasks)): ?>
                <p class="py-4 text-sm text-gray-400 text-center">No hay tareas recientes</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Budgets Column -->
    <div class="card p-6">
        <h2 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Últimos Presupuestos
        </h2>
        <div class="divide-y divide-gray-100">
            <?php foreach ($latestBudgets as $b): ?>
                <a href="/budgets/edit?id=<?= $b->id ?>" class="block py-3 hover:bg-gray-50 transition-colors">
                    <div class="font-bold text-gray-800 text-sm truncate" title="<?= h($b->title) ?>"><?= h($b->title) ?>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-xs font-black text-secondary"><?= formatCurrency($b->total) ?></span>
                        <span class="text-[9px] px-2 py-0.5 rounded-full font-black uppercase bg-gray-100 text-gray-600">
                            <?= h($b->status) ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (empty($latestBudgets)): ?>
                <p class="py-4 text-sm text-gray-400 text-center">No hay presupuestos recientes</p>
            <?php endif; ?>
        </div>
    </div>
</div>