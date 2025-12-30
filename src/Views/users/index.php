<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-secondary">Usuarios</h1>
        <p class="text-gray-600 mt-2">Gestión de usuarios del sistema</p>
    </div>
    <a href="/users/create" class="btn btn-primary">
        + Nuevo Usuario
    </a>
</div>

<div class="card overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-secondary"><?= h($user->name) ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        <?= h($user->email) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-lg <?= $user->role === 'admin' ? 'bg-special bg-opacity-10 text-special' : 'bg-gray-100 text-gray-800' ?>">
                            <?= h($user->role) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <?= formatDate($user->created_at) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex justify-end gap-3">
                            <a href="/users/edit?id=<?= $user->id ?>"
                                class="p-2 text-primary hover:bg-primary hover:text-white rounded-lg transition-all shadow-sm shadow-primary/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="/users/delete?id=<?= $user->id ?>" onclick="return confirm('¿Eliminar este usuario?')"
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