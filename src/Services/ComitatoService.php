<?php
namespace Services;

use PDO;

class ComitatoService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getComitati(): array {
        $stmt = $this->db->query("SELECT * FROM comitato");
        return $stmt->fetchAll();
    }

    public function getComitatiByProfile(int $profileId): array {
        $stmt = $this->db->prepare("SELECT * FROM comitato where id_profilo = :profileId");
        $stmt->execute([':profileId' => $profileId]);
        return $stmt->fetchAll();
    }

    public function createComitato(int $profileId, string $name, string $description): int {
        $stmt = $this->db->prepare("INSERT INTO comitato (nome, descrizione, id_profilo) VALUES (:name, :description, :profileId)");
        $stmt->execute(['name' => $name, 'description' => $description, 'profileId' => $profileId]);
        return $this->db->lastInsertId();
    }

    public function updateComitato(int $id, int $profileId, string $name, string $description): void {
        $stmt = $this->db->prepare("UPDATE comitato SET nome = :name, descrizione = :description, id_profilo = :profileId WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':profileId' => $profileId
        ]);
    }

    public function deletecomitato(int $id): void {
        $stmt = $this->db->prepare("DELETE from comitato  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
