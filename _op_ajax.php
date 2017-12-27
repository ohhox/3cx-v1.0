<?php

include './conf.php';

class op_ajax extends functionx {

    public function __construct() {
        parent::__construct();
    }

    public function getdidq() {
        $did = $this->getDid($_GET['pid']);
        echo json_encode($did);
    }

}

$op = $_GET['op'];
$m = new op_ajax();
$m->$op();
