<?php 

use Routing\Router\HttpReady as HttpReady;
class TestController implements HttpReady
{
    public function __construct() {
       // Constructor
    }

    public function index($id = null) {
        return "index";
    }

    public function get($id, $id2 = null) {
        return 'select patientId from patients where $patientId = ' . $id;
    }

    public function update ($id, $id2 = null) {
        // get the body
        return 'update patients set patient';
    }

    public function create() {
        return true;
    }

    public function delete($id, $id2 = null) {
        return true;
    }
}

