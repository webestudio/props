<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary">Editar Usuario</h1>
    <p class="text-gray-600 mt-2">Modificar datos del usuario</p>
</div>

<div class="card p-10 shadow-2xl">
    <form method="POST" action="/users/edit?id=<?= $user->id ?>" x-data="{ 
              name: '<?= h($user->name) ?>', 
              email: '<?= h($user->email) ?>', 
              password: '', 
              role: '<?= h($user->role) ?>' 
          }" @submit="if(!name || !email) { alert('Complete los campos requeridos'); $event.preventDefault(); }">

        <div class="mb-6">
            <label for="name" class="label-standard">Nombre *</label>
            <input type="text" id="name" name="name" x-model="name" required class="input-standard">
        </div>

        <div class="mb-6">
            <label for="email" class="label-standard">Email *</label>
            <input type="email" id="email" name="email" x-model="email" required class="input-standard">
        </div>

        <div class="mb-6">
            <label for="password" class="label-standard">
                Nueva Contraseña <span class="text-xs text-gray-400 normal-case">(dejar vacío para mantener
                    actual)</span>
            </label>
            <input type="password" id="password" name="password" x-model="password" class="input-standard">
        </div>

        <div class="mb-8">
            <label for="role" class="label-standard">Rol</label>
            <select id="role" name="role" x-model="role" class="input-standard">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-gray-100">
            <button type="submit" class="btn btn-primary px-10">
                Guardar Cambios
            </button>
            <a href="/users" class="btn btn-secondary px-8">
                Cancelar
            </a>
        </div>
    </form>
</div>