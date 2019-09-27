<?php 

namespace Routing\Router;

interface HttpReady {
    public function index($id = null);
    public function get($id, $id2 = null);
    public function create();
    public function update($id, $id2 = null);
    public function delete($id, $id2 = null);
}