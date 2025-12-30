<?php

namespace App\Models;

use App\Core\BaseModel;

class BudgetItem extends BaseModel
{
    protected static string $table = 'budget_items';

    public function budget(): ?Budget
    {
        if (!$this->budget_id) {
            return null;
        }

        return Budget::find($this->budget_id);
    }

    public function save(): bool
    {
        // Calculate total before saving
        $this->total = $this->quantity * $this->unit_price;

        $result = parent::save();

        // Recalculate budget totals
        if ($result && $this->budget_id) {
            $budget = $this->budget();
            if ($budget) {
                $budget->recalculate();
            }
        }

        return $result;
    }

    public function delete(): bool
    {
        $budgetId = $this->budget_id;
        $result = parent::delete();

        // Recalculate budget totals after deletion
        if ($result && $budgetId) {
            $budget = Budget::find($budgetId);
            if ($budget) {
                $budget->recalculate();
            }
        }

        return $result;
    }
}
