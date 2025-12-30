<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary">Nuevo Proyecto</h1>
    <p class="text-gray-600 mt-2">Crear un nuevo proyecto</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    <!-- Left Column: Project Form -->
    <div class="card p-10 shadow-2xl">
        <h2 class="text-xl font-bold text-secondary mb-6 border-b pb-4">Datos del Proyecto</h2>

        <form method="POST" action="/projects/create"
            x-data="{ name: '', client_id: '', description: '', status: 'active' }"
            @submit="if(!name || !client_id) { alert('Complete los campos obligatorios'); $event.preventDefault(); }">

            <div class="mb-6">
                <label for="client_id" class="label-standard">Cliente *</label>
                <select id="client_id" name="client_id" x-model="client_id" required class="input-standard">
                    <option value="">Seleccionar cliente...</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client->id ?>"><?= h($client->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="name" class="label-standard">Nombre del Proyecto *</label>
                <input type="text" id="name" name="name" x-model="name" required class="input-standard">
            </div>

            <div class="mb-6">
                <label for="description" class="label-standard">Descripción</label>
                <textarea id="description" name="description" x-model="description" rows="4"
                    class="input-standard"></textarea>
            </div>

            <div class="mb-8">
                <label for="status" class="label-standard">Estado</label>
                <select id="status" name="status" x-model="status" class="input-standard">
                    <option value="active">Activo</option>
                    <option value="completed">Completado</option>
                    <option value="cancelled">Cancelado</option>
                </select>
            </div>

            <div class="flex items-center gap-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary px-10 w-full sm:w-auto">
                    Crear Proyecto
                </button>
                <a href="/projects" class="btn btn-secondary px-8">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Right Column: Blocked Task Manager -->
    <div class="card p-8 shadow-xl opacity-60 relative overflow-hidden bg-gray-50 border border-gray-200">
        <div
            class="absolute inset-0 bg-white/50 backdrop-blur-[2px] z-10 flex flex-col items-center justify-center text-center p-8">
            <div class="bg-white p-4 rounded-full shadow-lg mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700">Gestión de Tareas Bloqueada</h3>
            <p class="text-gray-500 mt-2 max-w-xs">Guarda el proyecto primero para poder asignar tareas y gestionar el
                progreso.</p>
        </div>

        <!-- Mock Content for Visual Context -->
        <h2 class="text-xl font-bold text-gray-400 mb-6 border-b border-gray-200 pb-4">Tareas del Proyecto</h2>

        <div class="mb-8 p-4 bg-gray-100 rounded-lg border border-gray-200">
            <div class="flex justify-between text-sm font-bold text-gray-400 mb-2">
                <span>Progreso General</span>
                <span>0%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4"></div>
        </div>

        <div class="flex gap-4 mb-8 opacity-50">
            <input type="text" disabled placeholder="Nueva tarea..." class="input-standard flex-1 bg-gray-100">
            <button disabled class="btn btn-secondary px-4 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <div class="space-y-3 opacity-30">
            <div class="h-16 bg-gray-200 rounded-lg w-full"></div>
            <div class="h-16 bg-gray-200 rounded-lg w-full"></div>
            <div class="h-16 bg-gray-200 rounded-lg w-full"></div>
        </div>
    </div>
</div>