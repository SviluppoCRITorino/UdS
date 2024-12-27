<?php
namespace Models;

class Step {
    public $id;
    public $step;
    public $address;
    public $notes;
    public $itineraryId;

    public function __construct($id, $step, $address, $notes, $itineraryId) {
        $this->id = $id;
        $this->step = $step;
        $this->address = $address;
        $this->notes = $notes;
        $this->itineraryId = $itineraryId;
    }
}