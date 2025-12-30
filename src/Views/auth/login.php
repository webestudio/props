<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, noarchive">
    <title>Iniciar Sesión - Sistema de Presupuestos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

<body class="bg-global min-h-screen flex items-center justify-center p-4">
    <div class="card p-10 w-full max-w-md shadow-2xl">
        <div class="text-center mb-10">
            <div
                class="w-20 h-20 bg-primary rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg shadow-primary/20">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h1 class="text-3xl font-black text-secondary tracking-tighter italic">BUDGET<span
                    class="text-primary">PRO</span></h1>
            <p class="text-gray-500 mt-2 font-medium">Gestión de Presupuestos Digitales</p>
        </div>

        <?php if (isset($error)): ?>
            <div
                class="bg-red-50 border-2 border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login" x-data="{ email: '', password: '' }"
            @submit="if(!email || !password) { alert('Por favor complete todos los campos'); $event.preventDefault(); }">

            <div class="mb-4">
                <label for="email"
                    class="block text-secondary font-bold text-sm mb-2 uppercase tracking-widest">Email</label>
                <input type="email" id="email" name="email" x-model="email" required class="input-standard py-3"
                    placeholder="admin@agency.com">
            </div>

            <div class="mb-8">
                <label for="password"
                    class="block text-secondary font-bold text-sm mb-2 uppercase tracking-widest">Contraseña</label>
                <input type="password" id="password" name="password" x-model="password" required
                    class="input-standard py-3" placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary w-full py-4 text-lg shadow-lg">
                Iniciar Sesión
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-3">Acceso restringido</p>
            <p class="text-xs text-gray-400 font-bold tracking-widest mb-3">Algunos derechos reservados</p>
        </div>
    </div>
</body>

</html>