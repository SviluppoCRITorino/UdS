<?php
namespace Services;

use PDO;

class ProfileService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getProfiles(): array {
        $stmt = $this->db->query("SELECT * FROM profilo");
        return $stmt->fetchAll();
    }

    public function createProfile(string $name, int $initialData, int $checkBackPack, int $checkMaterials, int $itinerary, int $finalData, int $kilometers): int {
        $stmt = $this->db->prepare("INSERT INTO profilo (nome, dati_iniziali, check_zaino, check_materiale, percorso, dati_finali, chilometri_percorsi) VALUES (:name, :initialData, :checkBackPack, :checkMaterials, :itinerary, :finalData, :kilometers)");
        $stmt->execute([
            'name' => $name, 
            'initialData' => $initialData,
            'checkBackPack' => $checkBackPack,
            'checkMaterials' => $checkMaterials,
            'itinerary' => $itinerary,
            'finalData' => $finalData,
            'kilometers' => $kilometers]);
        return $this->db->lastInsertId();
    }

    public function updateProfile(int $id, string $name, int $initialData, int $checkBackPack, int $checkMaterials, int $itinerary, int $finalData, int $kilometers): void {
        $stmt = $this->db->prepare("UPDATE profilo SET nome = :name, dati_iniziali = :initialData, check_zaino = :checkBackPack, check_materiale = :checkMaterials, percorso = :itinerary, dati_finali = :finalData, chilometri_percorsi = :kilometers WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $name, 
            'initialData' => $initialData,
            'checkBackPack' => $checkBackPack,
            'checkMaterials' => $checkMaterials,
            'itinerary' => $itinerary,
            'finalData' => $finalData,
            'kilometers' => $kilometers]);
    }

    public function deleteProfile(int $id): void {
        $stmt = $this->db->prepare("DELETE from profilo  WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
    }
}
