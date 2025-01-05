<?php
namespace Services;

use PDO;

class MissionService {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function loadExistingMission(string $name, string $surname, int $idComitato) : array {
        $compilatore = trim($name) . " " . trim($surname);
        $stmt = $this->db->prepare("select * from missione where compilatore = :compilatore and id_comitato = :idComitato and data_fine is null");
        $stmt->execute([
            'compilatore' => $compilatore, 
            'idComitato' => $idComitato]);
        return $stmt->fetchAll();
    }

    public function createMission(string $name, string $surname, string $telephone, int $idComitato, int $idPercorso): int{
        $dateFormat = "Y-m-d H:i:s";
        $compilatore = trim($name) . " " . trim($surname);
        $stmt = $this->db->prepare("insert into missione (compilatore, telefono, id_comitato, id_percorso, data_inizio) values (:compilatore, :telephon, :idComitato, :idPercorso, :startDate )");
        $stmt->execute([
            'compilatore' => $compilatore, 
            'telephon' => $telephone,
            'idComitato' => $idComitato,
            'idPercorso' => $idPercorso,
            'startDate' => date($dateFormat)
        ]);
        return $this->db->lastInsertId();
    }

    public function updateMission(int $id, string $note, string $checkZaino, string $checkMateriali): void{
        $stmt = $this->db->prepare("update missione set note = :note, check_zaino = :checkZaino, check_materiali = :checkMateriali where id = :id");
        $stmt->execute([
            'id' => $id, 
            'note' => $note,
            'checkZaino' => $checkZaino,
            'checkMateriali' => $checkMateriali
        ]);
    }

    public function endMission(int $id, string $note, int $totalKm): void {
        $dateFormat = "Y-m-d H:i:s";
        $stmt = $this->db->prepare("update missione set note = :note, km_totali = :totalKM, data_fine = :endDate where id = :id");
        $stmt->execute([
            'id' => $id, 
            'note' => $note,
            'totalKM' => $totalKm,
            'endDate' => date($dateFormat)
        ]);
    }
}