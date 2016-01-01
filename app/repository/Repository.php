<?php

interface Repository {
    public function find($id, $with = array());
    public function all();
    public function save($entity);
    public function delete($entity);
    public function deleteById($id);
}