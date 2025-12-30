-- Create company_settings table
CREATE TABLE IF NOT EXISTS company_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL DEFAULT 'My Company',
    tax_id TEXT,
    address TEXT,
    city TEXT,
    zip TEXT,
    email TEXT,
    phone TEXT,
    website TEXT,
    logo_path TEXT,
    default_iva_rate REAL DEFAULT 21.0,
    default_irpf_rate REAL DEFAULT 15.0,
    budget_series TEXT DEFAULT '2025',
    current_budget_number INTEGER DEFAULT 0,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Initialize default settings
INSERT INTO company_settings (name) SELECT 'Agencia Digital' WHERE NOT EXISTS (SELECT 1 FROM company_settings);

-- Add new columns to budgets table
-- SQLite requires separate ALTER TABLE statements for each column
ALTER TABLE budgets ADD COLUMN series TEXT DEFAULT '2025';
ALTER TABLE budgets ADD COLUMN number INTEGER DEFAULT 0;
ALTER TABLE budgets ADD COLUMN irpf_rate REAL DEFAULT 0;
ALTER TABLE budgets ADD COLUMN has_irpf INTEGER DEFAULT 0; -- Boolean 0 or 1
