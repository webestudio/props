<?php

namespace App\Models;

use App\Core\BaseModel;

class Budget extends BaseModel
{
    protected static string $table = 'budgets';

    public function project(): ?Project
    {
        if (!$this->project_id) {
            return null;
        }

        return Project::find($this->project_id);
    }

    public function items(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM budget_items WHERE budget_id = ? ORDER BY id ASC");
        $stmt->execute([$this->id]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new BudgetItem($row), $rows);
    }

    public function recalculate(): void
    {
        $items = $this->items();
        $subtotal = array_reduce($items, fn($sum, $item) => $sum + $item->total, 0);

        $this->subtotal = $subtotal;

        $taxAmount = $subtotal * ($this->tax_rate / 100);
        $irpfAmount = ($this->has_irpf) ? $subtotal * ($this->irpf_rate / 100) : 0;

        $this->total = $subtotal + $taxAmount - $irpfAmount;
        $this->save();
    }
}
