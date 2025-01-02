<?php
namespace Models;

class Profile {
    public $id;
    public $name;
    public $initialData;
    public $checkBackPack;
    public $checkMaterials;
    public $itinerary;
    public $finalData;
    public $kilometers;



    public function __construct($id, $name, $initialData, $checkBackPack, $checkMaterials, $itinerary, $finalData, $kilometers) {
        $this->id = $id;
        $this->name = $name;
        $this->initialData = $initialData;
        $this->checkBackPack = $checkBackPack;
        $this->checkMaterials = $checkMaterials;
        $this->itinerary = $itinerary;
        $this->finalData = $finalData;
        $this->kilometers = $kilometers;
    }
}