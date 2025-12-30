<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary">Nuevo Usuario</h1>
    <p class="text-gray-600 mt-2">Crear un nuevo usuario del sistema</p>
</div>

<div class="card p-10 shadow-2xl">
    <form method="POST" action="/users/create" x-data="{ name: '', email: '', password: '', role: 'user' }"
        @submit="if(!name || !email || !password) { alert('Complete todos los campos'); $event.preventDefault(); }">

        <div class="mb-6">
            <label for="name" class="label-standard">Nombre</label>
            <input type="text" id="name" name="name" x-model="name" required class="input-standard">
        </div>

        <div class="mb-6">
            <label for="email" class="label-standard">Email</label>
            <input type="email" id="email" name="email" x-model="email" required class="input-standard">
        </div>

        <div class="mb-6">
            <label for="password" class="label-standard">Contraseña</label>
            <input type="password" id="password" name="password" x-model="password" required class="input-standard">
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
                Crear Usuario
            </button>
            <a href="/users" class="btn btn-secondary px-8">
                Cancelar
            </a>
        </div>
    </form>
</div>