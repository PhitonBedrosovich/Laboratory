<?php
abstract class AbstractTableModule {
    abstract public function insert($data);
    abstract public function getALl();
    abstract public function delete($id);
    abstract public function getById($id);
}