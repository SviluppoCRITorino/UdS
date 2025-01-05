<?php
namespace Models;

class Mission {
    public $id;
    public $compilatore;
    public $telefono;
    public $idComitato;
    public $idPercorso;
    public $dataInizio;
    public $dataFine;
    public $checkZaino;
    public $checkMateliali;
    public $note;
    public $totalKM;

    public function __construct($id, $compilatore, $telefono, $idComitato, $idPercorso, $dataInizio, $dataFine, $checkZaino, $checkMateliali, $note, $totalKM ) {
        $this->id = $id;
        $this->compilatore = $compilatore;
        $this->idComitato = $idComitato;
        $this->idPercorso = $idPercorso;
        $this->dataInizio = $dataInizio;
        $this->dataFine = $dataFine;
        $this->checkZaino = $checkZaino;
        $this->checkMateliali = $checkMateliali;
        $this->note = $note;
        $this->totalKM = $totalKM;
    }
}