<?php

interface iRepository {
    public function find($id);
    public function all();
    public function save($entity);
    public function delete($entity);
    public function deleteById($id);
}