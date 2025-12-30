<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, noarchive">
    <title>Sistema de Presupuestos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#17c3cc',
                        secondary: '#23282b',
                        special: '#6263ca',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-global h-screen overflow-hidden">
    <div x-data="{ 
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'true',
            currentPath: window.location.pathname,
            toasts: [],
            addToast(message, type = 'success') {
                const id = Date.now();
                this.toasts.push({ id, message, type });
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 4000);
            }
        }" x-init="
            $watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value));
            window.toast = (message, type) => $data.addToast(message, type);
        " class="flex h-screen relative">

        <!-- Toast Container -->
        <div class="toast-container">
            <template x-for="toast in toasts" :key="toast.id">
                <div class="toast border-l-4" :class="toast.type === 'success' ? 'border-primary' : 'border-red-500'">
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'success'">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-secondary" x-text="toast.message"></p>
                    </div>
                    <button @click="toasts = toasts.filter(t => t.id !== toast.id)"
                        class="ml-auto text-gray-400 hover:text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar-container w-56" :class="sidebarOpen ? 'w-56' : 'w-20'">

            <!-- Header -->
            <div class="sidebar-header">
                <div x-show="sidebarOpen" x-cloak class="flex items-center gap-3 overflow-hidden">
                    <div class="sidebar-logo-box">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-black tracking-tighter whitespace-nowrap">BUDGET<span
                            class="text-primary">PRO</span></h1>
                </div>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav custom-scrollbar">
                <a href="/dashboard" class="sidebar-link group" :class="{ 'active': currentPath === '/dashboard' }">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="font-medium">Dashboard</span>
                </a>

                <a href="/clients" class="sidebar-link group" :class="{ 'active': currentPath.startsWith('/clients') }">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="font-medium">Clientes</span>
                </a>

                <a href="/projects" class="sidebar-link group"
                    :class="{ 'active': currentPath.startsWith('/projects') }">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="font-medium">Proyectos</span>
                </a>

                <a href="/budgets" class="sidebar-link group" :class="{ 'active': currentPath.startsWith('/budgets') }">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="font-medium">Presupuestos</span>
                </a>

                <?php if (isAdmin()): ?>
                    <div class="sidebar-section-title" x-show="sidebarOpen" x-cloak>
                        Admin
                    </div>
                    <a href="/users" class="sidebar-link group"
                        :class="{ 'active-admin': currentPath.startsWith('/users') }">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-cloak class="font-medium">Usuarios</span>
                    </a>
                    <a href="/settings" class="sidebar-link group"
                        :class="{ 'active-admin': currentPath.startsWith('/settings') }">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-cloak class="font-medium">Configuración</span>
                    </a>
                <?php endif; ?>
            </nav>

            <!-- User info -->
            <div class="sidebar-footer">
                <div class="sidebar-user-card">
                    <div class="sidebar-avatar">
                        <span class="text-lg font-black text-white"><?= strtoupper(substr(auth()->name, 0, 1)) ?></span>
                    </div>
                    <div x-show="sidebarOpen" x-cloak class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate text-white"><?= h(auth()->name) ?></p>
                        <p class="text-xs text-gray-400 font-medium truncate"><?= h(auth()->role) ?></p>
                    </div>
                </div>
                <a href="/logout" x-show="sidebarOpen" x-cloak class="sidebar-logout-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar sesión
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-global">
            <div class="w-full p-4 lg:p-6 min-h-screen">
                <?= $content ?>
            </div>
        </main>
    </div>
</body>

</html>