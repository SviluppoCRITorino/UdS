<?php
namespace Services;

use PDO;

class MaterialService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getMaterials(): array {
        $stmt = $this->db->query("SELECT id, nome, descrizione FROM materiale");
        return $stmt->fetchAll();
    }

    public function createMaterial(string $name, string $description): int {
        $stmt = $this->db->prepare("INSERT INTO materiale (nome, descrizione) VALUES (:nome, :descrizione)");
        $stmt->execute(['nome' => $name, 'descrizione' => $description]);
        return $this->db->lastInsertId();
    }

    public function updateMaterial(int $id, string $name, string $description): void {
        $stmt = $this->db->prepare("UPDATE materiale SET nome = :name, descrizione = :description WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
        ]);
    }

    public function deleteMaterial(int $id): void {
        $stmt = $this->db->prepare("DELETE from materiale  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
