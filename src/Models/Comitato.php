<?php
namespace Models;

class Comitato {
    public $id;
    public $name;
    public $description;
    public $profileId;

    public function __construct($id, $name, $description, $profileId) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->profileId = $profileId;
    }
}