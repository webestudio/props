<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary">Configuración de Empresa</h1>
    <p class="text-gray-600 mt-2">Personaliza la información que aparecerá en tus presupuestos</p>
</div>

<div class="card p-10 shadow-2xl">
    <form method="POST" action="/settings" enctype="multipart/form-data">

        <!-- Logo Section -->
        <div class="mb-10 flex items-center gap-8 pb-10 border-b border-gray-100">
            <div
                class="w-32 h-32 bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center overflow-hidden relative group">
                <?php if ($settings->logo_path): ?>
                    <img src="<?= h($settings->logo_path) ?>" class="w-full h-full object-contain p-2">
                <?php else: ?>
                    <div class="text-gray-400 text-center">
                        <svg class="w-10 h-10 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs font-bold uppercase">Sin Logo</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-1">
                <label class="label-standard">Logotipo</label>
                <div class="flex items-center gap-4">
                    <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-primary file:bg-opacity-10 file:text-primary
                        hover:file:bg-opacity-20 transition-all cursor-pointer
                    " />
                </div>
                <p class="mt-2 text-xs text-gray-500">Recomendado: PNG transparente, máx 2MB</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Left Column: Company Info -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-secondary border-b pb-2">Información Fiscal</h3>

                <div>
                    <label for="name" class="label-standard">Nombre de Empresa / Autónomo</label>
                    <input type="text" name="name" value="<?= h($settings->name) ?>" class="input-standard">
                </div>

                <div>
                    <label for="tax_id" class="label-standard">CIF / NIF</label>
                    <input type="text" name="tax_id" value="<?= h($settings->tax_id ?? '') ?>" class="input-standard">
                </div>

                <div>
                    <label for="address" class="label-standard">Dirección</label>
                    <input type="text" name="address" value="<?= h($settings->address ?? '') ?>" class="input-standard">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="label-standard">Ciudad</label>
                        <input type="text" name="city" value="<?= h($settings->city ?? '') ?>" class="input-standard">
                    </div>
                    <div>
                        <label for="zip" class="label-standard">Código Postal</label>
                        <input type="text" name="zip" value="<?= h($settings->zip ?? '') ?>" class="input-standard">
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact & Defaults -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-secondary border-b pb-2">Contacto y Valores por Defecto</h3>

                <div>
                    <label for="email" class="label-standard">Email de Contacto</label>
                    <input type="email" name="email" value="<?= h($settings->email ?? '') ?>" class="input-standard">
                </div>

                <div>
                    <label for="phone" class="label-standard">Teléfono</label>
                    <input type="text" name="phone" value="<?= h($settings->phone ?? '') ?>" class="input-standard">
                </div>

                <div>
                    <label for="website" class="label-standard">Sitio Web</label>
                    <input type="text" name="website" value="<?= h($settings->website ?? '') ?>" class="input-standard">
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div>
                        <label for="default_iva_rate" class="label-standard text-primary">IVA por Defecto (%)</label>
                        <input type="number" step="0.01" name="default_iva_rate"
                            value="<?= h($settings->default_iva_rate) ?>" class="input-standard">
                    </div>
                    <div>
                        <label for="default_irpf_rate" class="label-standard text-special">IRPF por Defecto (%)</label>
                        <input type="number" step="0.01" name="default_irpf_rate"
                            value="<?= h($settings->default_irpf_rate) ?>" class="input-standard">
                    </div>
                </div>

                <div>
                    <label for="budget_series" class="label-standard">Serie de Facturación Actual</label>
                    <input type="text" name="budget_series" value="<?= h($settings->budget_series) ?>"
                        class="input-standard w-1/2">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100">
            <button type="submit" class="btn btn-primary px-10">
                Guardar Configuración
            </button>
        </div>
    </form>
</div>