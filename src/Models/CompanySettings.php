<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class CompanySettings
{
    public $id;
    public $name;
    public $tax_id;
    public $address;
    public $city;
    public $zip;
    public $email;
    public $phone;
    public $website;
    public $logo_path;
    public $default_iva_rate;
    public $default_irpf_rate;
    public $budget_series;
    public $current_budget_number;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function get(): self
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM company_settings LIMIT 1");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            // Should be initialized by migration, but fallback just in case
            $db->exec("INSERT INTO company_settings (name) VALUES ('Agencia Digital')");
            return self::get();
        }

        return new self($data);
    }

    public function save(): bool
    {
        $db = Database::connect();
        $sql = "UPDATE company_settings SET 
                name = :name,
                tax_id = :tax_id,
                address = :address,
                city = :city,
                zip = :zip,
                email = :email,
                phone = :phone,
                website = :website,
                logo_path = :logo_path,
                default_iva_rate = :default_iva_rate,
                default_irpf_rate = :default_irpf_rate,
                budget_series = :budget_series
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':name' => $this->name,
            ':tax_id' => $this->tax_id,
            ':address' => $this->address,
            ':city' => $this->city,
            ':zip' => $this->zip,
            ':email' => $this->email,
            ':phone' => $this->phone,
            ':website' => $this->website,
            ':logo_path' => $this->logo_path,
            ':default_iva_rate' => $this->default_iva_rate,
            ':default_irpf_rate' => $this->default_irpf_rate,
            ':budget_series' => $this->budget_series,
            ':id' => $this->id
        ]);
    }

    public function incrementBudgetNumber(): int
    {
        $db = Database::connect();
        $db->exec("UPDATE company_settings SET current_budget_number = current_budget_number + 1 WHERE id = " . $this->id);
        return $this->current_budget_number + 1;
    }
}
