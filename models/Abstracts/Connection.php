<?php
namespace Abstracts;

abstract class Connection {
    private $mysqli;

    private function __construct(){}

    protected function makeConnection() {
        if (!$this->mysqli) $this->mysqli = mysqli_connect('localhost', 'root', '', 'dbpenta');

        return $this->mysqli;
    }

    public function __destruct(){
        if ($this->mysqli) mysqli_close($this->mysqli);
    }
}
?>