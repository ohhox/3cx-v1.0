<?php

include './conf.php';

class op_main extends functionx {

    public function __construct() {
        parent::__construct();
    }

    public function saveProject() {
        $this->table = "Projects";
        $this->pk = 'ProjectID';

        $this->__setMultiple($_POST);
        $this->create();
        $this->Go("manage_project.php");
    }

    public function editProject() {
        $this->table = "Projects";
        $this->pk = 'ProjectID';

        $this->__setMultiple($_POST);
        $this->save($_GET['id']);
        $this->Go("manage_project.php");
    }

    public function removeProject() {
        $this->table = "Projects";
        $this->pk = 'ProjectID';
        if (!empty($_GET['id'])) {
            $this->delete($_GET['id']);
        }
        $this->Go("manage_project.php");
    }

    public function saveDidQueres() {
        $this->table = "DIDQueues";
        $this->pk = 'DIDQueueID';

        $this->__setMultiple($_POST);
        $this->create();
         $this->Go("manage_queses.php");
    }

    public function editDidQueres() {
        $this->table = "DIDQueues";
        $this->pk = 'DIDQueueID';

        $this->__setMultiple($_POST);
        $this->save($_GET['id']);
        $this->Go("manage_queses.php");
    }

    public function removeDidQueres() {
        $this->table = "DIDQueues";
        $this->pk = 'DIDQueueID';
        if (!empty($_GET['id'])) {
            $this->delete($_GET['id']);
        }
        $this->Go("manage_queses.php");
    }

}

$op = $_GET['op'];
$m = new op_main();
$m->$op();
