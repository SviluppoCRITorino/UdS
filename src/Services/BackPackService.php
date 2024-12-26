<?php
namespace Services;

use PDO;

class BackPackService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getBackPackItems(): array {
        $stmt = $this->db->query("SELECT id, elemento, numero FROM zaino");
        return $stmt->fetchAll();
    }

    public function createBackPackItem(string $item, int $number): int {
        $stmt = $this->db->prepare("INSERT INTO zaino (elemento, numero) VALUES (:elemento, :numero)");
        $stmt->execute(['elemento' => $item, 'numero' => $number]);
        return $this->db->lastInsertId();
    }

    public function updateBackPackItem(int $id, string $item, int $number): void {
        $stmt = $this->db->prepare("UPDATE zaino SET elemento = :item, numero = :number WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':item' => $item,
            ':number' => $number,
        ]);
    }

    public function deleteBackPackItem(int $id): void {
        $stmt = $this->db->prepare("DELETE from zaino  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
