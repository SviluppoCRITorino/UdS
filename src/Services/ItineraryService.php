<?php
namespace Services;

use PDO;

class ItineraryService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getItineraries(): array {
        $stmt = $this->db->query("SELECT id, percorso, descrizione FROM percorso");
        return $stmt->fetchAll();
    }

    public function createItinerary(string $name, string $description): int {
        $stmt = $this->db->prepare("INSERT INTO percorso (percorso, descrizione) VALUES (:nome, :descrizione)");
        $stmt->execute(['nome' => $name, 'descrizione' => $description]);
        return $this->db->lastInsertId();
    }

    public function updateItinerary(int $id, string $name, string $description): void {
        $stmt = $this->db->prepare("UPDATE percorso SET percorso = :name, descrizione = :description WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
        ]);
    }

    public function deleteItinerary(int $id): void {
        $stmt = $this->db->prepare("DELETE from percorso  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
