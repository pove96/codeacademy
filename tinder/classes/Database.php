<?php

class Database {

    private $naujasfailas;

    public function __construct($naujasfailas) {
        $this->naujasfailas = $naujasfailas;
        $this->init();
    }

    public function init() {
        if (!file_exists($this->naujasfailas)) {
            file_put_contents($this->naujasfailas, '');
        }
    }

    public function load() {
        $content = file_get_contents($this->naujasfailas);
        return unserialize($content);
    }

    public function save($content) {
        file_put_contents($this->naujasfailas, serialize($content));
    }

    public function delete() {
        unlink($this->naujasfailas);
    }

}
