<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary">Editar Proyecto</h1>
    <p class="text-gray-600 mt-2">Modificar datos y gestionar tareas</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    <!-- Left Column: Project Form -->
    <div class="card p-10 shadow-2xl">
        <h2 class="text-xl font-bold text-secondary mb-6 border-b pb-4">Datos del Proyecto</h2>

        <form method="POST" action="/projects/edit?id=<?= $project->id ?>" x-data="{ 
                  name: '<?= h($project->name) ?>', 
                  client_id: '<?= $project->client_id ?>', 
                  description: '<?= h($project->description ?? '') ?>', 
                  status: '<?= $project->status ?>' 
              }"
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
                    class="input-standard"><?= h($project->description ?? '') ?></textarea>
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
                    Guardar Cambios
                </button>
                <a href="/projects" class="btn btn-secondary px-8">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Right Column: Task Manager -->
    <div class="card p-8 shadow-xl" x-data="{
        tasks: <?= htmlspecialchars(json_encode(array_map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'status' => $t->status, 'priority' => $t->priority], $project->tasks())), ENT_QUOTES) ?>,
        newTask: '',
        newPriority: 'medium',

        addTask() {
            if (!this.newTask) return;

            fetch('/tasks/create', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    project_id: <?= $project->id ?>,
                    title: this.newTask,
                    priority: this.newPriority
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.tasks.unshift({
                        id: data.id, 
                        title: this.newTask, 
                        status: 'pending', 
                        priority: this.newPriority
                    });
                    this.newTask = '';
                    window.toast('Tarea añadida', 'success');
                }
            });
        },

        toggleStatus(task) {
            const newStatus = task.status === 'completed' ? 'pending' : 'completed';
            
            fetch('/tasks/update?id=' + task.id, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    task.status = newStatus;
                }
            });
        },

        deleteTask(index, id) {
            if (!confirm('¿Eliminar esta tarea?')) return;

            fetch('/tasks/delete?id=' + id, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.tasks.splice(index, 1);
                    window.toast('Tarea eliminada', 'success');
                }
            });
        },

        get progress() {
            if (this.tasks.length === 0) return 0;
            const completed = this.tasks.filter(t => t.status === 'completed').length;
            return Math.round((completed / this.tasks.length) * 100);
        }
    }">
        <h2 class="text-xl font-bold text-secondary mb-6 border-b pb-4">Tareas del Proyecto</h2>

        <!-- Progress Bar -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
            <div class="flex justify-between text-sm font-bold text-gray-600 mb-2">
                <span>Progreso General</span>
                <span x-text="progress + '%'"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="bg-primary h-4 transition-all duration-500 rounded-full"
                    :style="'width: ' + progress + '%'">
                </div>
            </div>
        </div>

        <!-- Add Task Form -->
        <div class="flex gap-4 mb-8">
            <input type="text" x-model="newTask" @keydown.enter="addTask()" placeholder="Nueva tarea..."
                class="input-standard flex-1">
            <select x-model="newPriority" class="input-standard w-32">
                <option value="low">Baja</option>
                <option value="medium">Media</option>
                <option value="high">Alta</option>
            </select>
            <button @click="addTask()" class="btn btn-secondary px-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <!-- Task List -->
        <div class="space-y-3 max-h-[500px] overflow-y-auto custom-scrollbar pr-2">
            <template x-for="(task, index) in tasks" :key="task.id">
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all"
                    :class="{'opacity-75': task.status === 'completed'}">

                    <div class="flex items-center gap-4 flex-1">
                        <button @click="toggleStatus(task)"
                            class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors flex-shrink-0"
                            :class="task.status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 hover:border-primary'">
                            <svg x-show="task.status === 'completed'" class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-800 truncate"
                                :class="{'line-through text-gray-400': task.status === 'completed'}"
                                x-text="task.title">
                            </p>
                        </div>

                        <span class="text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wide flex-shrink-0"
                            :class="{
                                  'bg-red-100 text-red-600': task.priority === 'high',
                                  'bg-yellow-100 text-yellow-600': task.priority === 'medium',
                                  'bg-green-100 text-green-600': task.priority === 'low'
                              }" x-text="task.priority">
                        </span>
                    </div>

                    <button @click="deleteTask(index, task.id)"
                        class="ml-3 text-gray-300 hover:text-red-500 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </template>

            <div x-show="tasks.length === 0"
                class="text-center py-12 text-gray-400 border-2 border-dashed border-gray-100 rounded-lg">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>No hay tareas en este proyecto.</p>
                <p class="text-sm mt-1">¡Añade la primera!</p>
            </div>
        </div>
    </div>
</div>