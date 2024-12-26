<?php
namespace Models;

class BackPack {
    public $id;
    public $item;
    public $number;

    public function __construct($id, $item, $number) {
        $this->id = $id;
        $this->item = $item;
        $this->number = $number;
    }
}
