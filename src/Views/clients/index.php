<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-secondary">Clientes</h1>
        <p class="text-gray-600 mt-2 font-medium">Gestión y seguimiento de tu cartera de clientes</p>
    </div>
    <a href="/clients/create" class="btn btn-primary shadow-lg shadow-primary/20">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Cliente
        </span>
    </a>
</div>

<!-- Search and Filter Bar -->
<div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between" x-data="{ 
    search: '<?= h($search) ?>',
    perPage: '<?= $pagination['per_page'] ?>',
    updateResults() {
        const url = new URL(window.location);
        url.searchParams.set('search', this.search);
        url.searchParams.set('per_page', this.perPage);
        url.searchParams.set('page', 1);
        window.location = url;
    }
}">
    <div class="relative w-full md:w-96 group">
        <input type="text" x-model="search" @keyup.enter="updateResults()" placeholder="Buscar cliente..."
            class="input-standard pl-12 pr-24 py-3 bg-white border-2 border-transparent focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none rounded-2xl shadow-sm">
        <div
            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <button @click="updateResults()"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-black uppercase text-gray-400 hover:text-primary tracking-widest transition-colors">
            Buscar
        </button>
    </div>

    <div class="flex items-center gap-3">
        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Mostrar</span>
        <select x-model="perPage" @change="updateResults()"
            class="input-standard py-2 pl-4 pr-10 bg-white cursor-pointer border-transparent shadow-sm">
            <option value="10">10</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="0">Todos</option>
        </select>
    </div>
</div>

<div class="card overflow-hidden shadow-2xl border-0">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Nombre
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Empresa
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Email
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Teléfono
                    </th>
                    <th class="px-8 py-5 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($clients as $client): ?>
                    <tr class="hover:bg-primary/5 transition-all duration-300 group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-black text-sm">
                                    <?= strtoupper(substr($client->name, 0, 1)) ?>
                                </div>
                                <div class="font-bold text-secondary text-sm"><?= h($client->name) ?></div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-sm text-gray-500 font-medium"><?= h($client->company ?: '-') ?></span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-sm text-gray-500 font-medium"><?= h($client->email ?: '-') ?></span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-gray-500 font-medium italic text-sm">
                            <?= h($client->phone ?: '-') ?>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="/clients/edit?id=<?= $client->id ?>"
                                    class="p-2 rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all shadow-lg shadow-primary/5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="/clients/delete?id=<?= $client->id ?>"
                                    onclick="return confirm('¿Eliminar este cliente?')"
                                    class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-lg shadow-red-500/5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">No se encontraron clientes
                            </p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <?php if ($pagination['pages'] > 1 || $pagination['total'] > 0): ?>
        <div
            class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-xs font-black uppercase tracking-widest text-gray-400">
                Mostrando <?= count($clients) ?> de <?= $pagination['total'] ?> clientes
            </div>

            <?php if ($pagination['pages'] > 1): ?>
                <div class="flex items-center gap-2">
                    <?php if ($pagination['current_page'] > 1): ?>
                        <a href="?page=<?= $pagination['current_page'] - 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $pagination['per_page'] ?>"
                            class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:border-primary hover:text-primary transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                        <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
                            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&per_page=<?= $pagination['per_page'] ?>"
                                class="px-4 py-2 rounded-lg font-black text-xs transition-all <?= $i === $pagination['current_page'] ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:text-primary' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>

                    <?php if ($pagination['current_page'] < $pagination['pages']): ?>
                        <a href="?page=<?= $pagination['current_page'] + 1 ?>&search=<?= urlencode($search) ?>&per_page=<?= $pagination['per_page'] ?>"
                            class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:border-primary hover:text-primary transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>