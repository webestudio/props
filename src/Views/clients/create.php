<div class="mb-8">
    <h1 class="text-4xl font-black text-secondary tracking-tighter">Nuevo Cliente</h1>
    <p class="text-gray-500 mt-2 font-medium">Registra los detalles del nuevo prospecto o empresa</p>
</div>

<div class="card p-10 shadow-2xl">
    <form method="POST" action="/clients/create" x-data="{ name: '', email: '', phone: '', company: '' }"
        @submit="if(!name) { window.toast('El nombre es obligatorio', 'error'); $event.preventDefault(); }">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Left Column -->
            <div class="space-y-6">
                <div>
                    <label for="name" class="label-standard">Nombre Completo *</label>
                    <div class="input-group">
                        <input type="text" id="name" name="name" x-model="name" required
                            class="input-standard input-with-icon" placeholder="Ej: Juan Pérez">
                        <div class="input-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="company" class="label-standard">Empresa / Negocio</label>
                    <div class="input-group">
                        <input type="text" id="company" name="company" x-model="company"
                            class="input-standard input-with-icon" placeholder="Nombre de la compañía">
                        <div class="input-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <div>
                    <label for="email" class="label-standard">Correo Electrónico</label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" x-model="email"
                            class="input-standard input-with-icon" placeholder="ejemplo@correo.com">
                        <div class="input-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="phone" class="label-standard">Teléfono de contacto</label>
                    <div class="input-group">
                        <input type="tel" id="phone" name="phone" x-model="phone" class="input-standard input-with-icon"
                            placeholder="+34 000 000 000">
                        <div class="input-icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <label for="notes" class="label-standard">Notas / Observaciones</label>
            <textarea id="notes" name="notes" class="input-standard h-32"
                placeholder="Información adicional sobre el cliente..."></textarea>
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-gray-100">
            <button type="submit" class="btn btn-primary px-10 py-4 shadow-lg shadow-primary/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Crear Cliente
            </button>
            <a href="/clients"
                class="btn btn-secondary px-8 font-bold text-sm uppercase tracking-widest transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>