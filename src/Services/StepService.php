<?php
namespace Services;

use PDO;

class StepService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getStepsByItineraryId(int $itineraryId): array {
        $stmt = $this->db->prepare("SELECT id, tappa, indirizzo, note FROM tappa where id_percorso = :itineraryId");
        $stmt->execute([':itineraryId' => $itineraryId]);
        return $stmt->fetchAll();
    }

    public function createStepByItineraryId(int $itineraryId, string $step, string $address, string $notes): int {
        $stmt = $this->db->prepare("INSERT INTO tappa (tappa, indirizzo, note, id_percorso) VALUES (:step, :address, :notes, :itineraryId)");
        $stmt->execute(['step' => $step, 'address' => $address, 'notes' => $notes, 'itineraryId' => $itineraryId]);
        return $this->db->lastInsertId();
    }

    public function updateStep(int $id, string $step, string $address, string $notes): void {
        $stmt = $this->db->prepare("UPDATE tappa SET tappa = :step, indirizzo = :address, note = :notes WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':step' => $step,
            ':address' => $address,
            ':notes' => $notes
        ]);
    }

    public function deleteStep(int $id): void {
        $stmt = $this->db->prepare("DELETE from tappa  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
