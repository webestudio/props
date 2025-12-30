<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-secondary">Editar Presupuesto
            #<?= h($budget->series . '-' . str_pad($budget->number, 4, '0', STR_PAD_LEFT)) ?></h1>
        <p class="text-gray-600 mt-2">Modifica los detalles y conceptos del presupuesto</p>
    </div>
    <div class="flex gap-4">
        <a href="/budgets/export/pdf?id=<?= $budget->id ?>" target="_blank" class="btn btn-secondary gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Exportar PDF
        </a>
    </div>
</div>

<div class="card p-10 shadow-2xl" x-data="{ 
        items: <?= htmlspecialchars(json_encode(array_map(fn($i) => ['id' => $i->id, 'concept' => $i->concept, 'quantity' => $i->quantity, 'unit_price' => $i->unit_price, 'total' => $i->total], $items)), ENT_QUOTES) ?>,
        tax_rate: <?= $budget->tax_rate ?>,
        irpf_rate: <?= $budget->irpf_rate ?? 0 ?>,
        has_irpf: <?= $budget->has_irpf ? 'true' : 'false' ?>,
        subtotal: 0,
        iva_amount: 0,
        irpf_amount: 0,
        total: 0,

        addItem() {
            this.items.push({ concept: '', quantity: 1, unit_price: 0, total: 0 });
        },

        removeItem(index) {
            this.items = this.items.filter((_, i) => i !== index);
            this.calculateTotals();
        },

        calculateRow(item) {
            item.total = parseFloat(item.quantity) * parseFloat(item.unit_price);
            this.calculateTotals();
        },

        calculateTotals() {
            this.subtotal = this.items.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);
            this.iva_amount = this.subtotal * (this.tax_rate / 100);
            this.irpf_amount = this.has_irpf ? (this.subtotal * (this.irpf_rate / 100)) : 0;
            this.total = this.subtotal + this.iva_amount - this.irpf_amount;
        },

        submitBudget() {
            if (!this.items.length) {
                window.toast('Añade al menos un concepto', 'error');
                return;
            }

            const formData = new FormData(document.getElementById('budgetForm'));
            const data = Object.fromEntries(formData.entries());
            
            data.items = this.items;
            data.has_irpf = this.has_irpf;
            data.irpf_rate = this.irpf_rate;
            data.tax_rate = this.tax_rate;
            
            fetch('/budgets/edit?id=<?= $budget->id ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(async response => {
                const result = await response.json();
                if (response.ok && result.success) {
                    window.toast('Presupuesto actualizado correctamente', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                     const errorMsg = result.error || 'Error al guardar el presupuesto';
                     console.error('Server Error:', result);
                     window.toast(errorMsg, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.toast('Error de conexión: ' + error.message, 'error');
            });
        }
    }"
    x-init="calculateTotals(); $watch('items', () => calculateTotals()); $watch('tax_rate', () => calculateTotals()); $watch('irpf_rate', () => calculateTotals()); $watch('has_irpf', () => calculateTotals());">

    <form id="budgetForm" @submit.prevent="submitBudget" class="space-y-8">
        <!-- Header Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-gray-100">
            <div class="space-y-6">
                <div>
                    <label class="label-standard">Cliente</label>
                    <!-- Client is typically fixed in Edit, but we can allow changing projects/clients via controller logic if needed. 
                        For now, let's keep it read-only or show the project name -->
                    <div class="text-lg font-bold text-gray-800 p-2 bg-gray-50 rounded border border-gray-200">
                        <?= h($budget->project()->client()->name ?? 'Cliente desconocido') ?>
                        <span
                            class="text-sm font-normal text-gray-500 block"><?= h($budget->project()->name ?? '') ?></span>
                    </div>
                </div>

                <div>
                    <label for="title" class="label-standard">Título del Presupuesto *</label>
                    <input type="text" id="title" name="title" value="<?= h($budget->title) ?>" required
                        class="input-standard">
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="valid_until" class="label-standard">Válido Hasta</label>
                        <input type="date" id="valid_until" name="valid_until" value="<?= h($budget->valid_until) ?>"
                            class="input-standard">
                    </div>
                    <div>
                        <label for="status" class="label-standard">Estado</label>
                        <select id="status" name="status" class="input-standard">
                            <option value="draft" <?= $budget->status === 'draft' ? 'selected' : '' ?>>Borrador</option>
                            <option value="sent" <?= $budget->status === 'sent' ? 'selected' : '' ?>>Enviado</option>
                            <option value="approved" <?= $budget->status === 'approved' ? 'selected' : '' ?>>Aprobado
                            </option>
                            <option value="rejected" <?= $budget->status === 'rejected' ? 'selected' : '' ?>>Rechazado
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="label-standard">Notas / Descripción</label>
                    <textarea id="description" name="description" rows="3"
                        class="input-standard"><?= h($budget->description) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-secondary">Conceptos</h3>
                <button type="button" @click="addItem()"
                    class="txt-primary hover:text-primary-dark font-bold text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Añadir Línea
                </button>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <div
                    class="hidden md:grid grid-cols-12 gap-4 mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest px-2">
                    <div class="col-span-6">Concepto</div>
                    <div class="col-span-2 text-right">Cant.</div>
                    <div class="col-span-2 text-right">Precio</div>
                    <div class="col-span-2 text-right">Total</div>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div
                            class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start relative group bg-white p-3 rounded-lg shadow-sm border border-gray-100">

                            <!-- Remove Button -->
                            <button type="button" @click="removeItem(index)"
                                class="absolute -top-2 -right-2 md:top-3 md:-left-8 w-8 h-8 flex items-center justify-center bg-red-100 text-red-500 rounded-full hover:bg-red-200 transition-colors shadow-sm z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="col-span-6">
                                <input type="text" x-model="item.concept" placeholder="Descripción"
                                    class="input-standard text-sm w-full" required>
                            </div>

                            <div class="col-span-2">
                                <input type="number" x-model="item.quantity" @input="calculateRow(item)" step="0.01"
                                    class="input-standard text-sm text-right w-full">
                            </div>

                            <div class="col-span-2">
                                <input type="number" x-model="item.unit_price" @input="calculateRow(item)" step="0.01"
                                    class="input-standard text-sm text-right w-full">
                            </div>

                            <div class="col-span-2 flex items-center justify-end">
                                <span class="font-bold text-secondary text-lg"
                                    x-text="parseFloat(item.total).toFixed(2) + ' €'"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addItem()"
                    class="mt-4 w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-400 font-bold hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Añadir Nuevo Concepto
                </button>
            </div>
        </div>

        <!-- Totals & Taxes -->
        <div class="flex flex-col md:flex-row justify-end pt-6 border-t border-gray-100 gap-8">
            <div class="w-full md:w-80 space-y-4">

                <!-- Tax Controls -->
                <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-bold text-gray-600">IVA (%)</label>
                        <input type="number" x-model="tax_rate" class="input-standard w-20 text-right h-8" step="0.1">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="has_irpf" class="rounded text-primary focus:ring-primary">
                            <span class="text-sm font-bold text-gray-600">Aplicar IRPF</span>
                        </label>
                        <input type="number" x-model="irpf_rate" :disabled="!has_irpf"
                            class="input-standard w-20 text-right h-8 disabled:opacity-50" step="0.1">
                    </div>
                </div>

                <!-- Summary -->
                <div class="space-y-2 text-right">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span class="font-medium" x-text="subtotal.toFixed(2) + ' €'"></span>
                    </div>

                    <div class="flex justify-between text-gray-500">
                        <span>IVA (<span x-text="tax_rate"></span>%)</span>
                        <span class="font-medium" x-text="iva_amount.toFixed(2) + ' €'"></span>
                    </div>

                    <div class="flex justify-between text-special" x-show="has_irpf">
                        <span>- IRPF (<span x-text="irpf_rate"></span>%)</span>
                        <span class="font-medium" x-text="'-' + irpf_amount.toFixed(2) + ' €'"></span>
                    </div>

                    <div
                        class="flex justify-between text-2xl font-black text-secondary pt-4 border-t border-gray-200 mt-2">
                        <span>Total</span>
                        <span x-text="total.toFixed(2) + ' €'"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100">
            <button type="submit" class="btn btn-primary px-10">
                Guardar Cambios
            </button>
            <a href="/budgets" class="btn btn-secondary px-8">
                Cancelar
            </a>
        </div>
    </form>
</div>