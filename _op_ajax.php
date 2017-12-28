<?php

include './conf.php';

class op_ajax extends functionx {

    public function __construct() {
        parent::__construct();
    }

    public function getdidA() {
        $did = $this->getDid($_GET['pid']);
        echo json_encode($did);
    }

    public function getQueueA() {
        $did = $this->getQueue($_GET['did']);
        echo json_encode($did);
    }

}

$op = $_GET['op'];
$m = new op_ajax();
$m->$op();
