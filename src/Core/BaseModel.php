<?php

namespace App\Core;

use App\Config\Database;
use PDO;

abstract class BaseModel
{
    protected static string $table = '';
    protected PDO $db;
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->db = Database::connect();
        $this->attributes = $attributes;
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public static function all(): array
    {
        $db = Database::connect();
        $table = static::$table;
        $stmt = $db->query("SELECT * FROM {$table} ORDER BY id DESC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new static($row), $rows);
    }

    public static function find(int $id): ?static
    {
        $db = Database::connect();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM {$table} WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? new static($row) : null;
    }

    public function save(): bool
    {
        $this->attributes['updated_at'] = date('Y-m-d H:i:s');

        if (isset($this->attributes['id'])) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    protected function insert(): bool
    {
        $this->attributes['created_at'] = date('Y-m-d H:i:s');
        $columns = array_keys($this->attributes);
        $placeholders = array_fill(0, count($columns), '?');

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(array_values($this->attributes));

        if ($result) {
            $this->attributes['id'] = (int) $this->db->lastInsertId();
        }

        return $result;
    }

    protected function update(): bool
    {
        $columns = array_keys($this->attributes);
        $setClause = implode(', ', array_map(fn($col) => "{$col} = ?", $columns));

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = ?",
            static::$table,
            $setClause
        );

        $values = array_values($this->attributes);
        $values[] = $this->attributes['id'];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete(): bool
    {
        if (!isset($this->attributes['id'])) {
            return false;
        }

        $sql = sprintf("DELETE FROM %s WHERE id = ?", static::$table);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->attributes['id']]);
    }

    public static function where(string $column, mixed $value): array
    {
        $db = Database::connect();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM {$table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new static($row), $rows);
    }

    public static function paginate(int $page = 1, int $perPage = 10, string $search = '', array $searchColumns = []): array
    {
        $db = Database::connect();
        $table = static::$table;
        $params = [];
        $whereSql = "";

        if ($search && !empty($searchColumns)) {
            $clauses = [];
            foreach ($searchColumns as $col) {
                $clauses[] = "{$col} LIKE ?";
                $params[] = "%{$search}%";
            }
            $whereSql = " WHERE " . implode(" OR ", $clauses);
        }

        // Get total count
        $countStmt = $db->prepare("SELECT COUNT(*) as count FROM {$table} {$whereSql}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()['count'];

        // Build main query
        $sql = "SELECT * FROM {$table} {$whereSql} ORDER BY created_at DESC, id DESC";

        if ($perPage > 0) {
            $sql .= " LIMIT ? OFFSET ?";
            $offset = ($page - 1) * $perPage;
            $params[] = $perPage;
            $params[] = $offset;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        return [
            'data' => array_map(fn($row) => new static($row), $rows),
            'total' => $total,
            'pages' => $perPage > 0 ? ceil($total / $perPage) : 1,
            'current_page' => $page,
            'per_page' => $perPage
        ];
    }

    public static function latest(int $limit = 3): array
    {
        $db = Database::connect();
        $table = static::$table;
        $stmt = $db->query("SELECT * FROM {$table} ORDER BY created_at DESC, id DESC LIMIT {$limit}");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new static($row), $rows);
    }

    public static function count(string $where = '', array $params = []): int
    {
        $db = Database::connect();
        $table = static::$table;
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['count'];
    }
}
