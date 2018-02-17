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

    public function getAgent() {
        $project = "";
        $DID = "";
        $Queues = "";
        if (isset($_GET['project'])) {
            $project = $_GET['project'];
        }
        if (isset($_GET['did'])) {
            $DID = $_GET['did'];
        }
        if (isset($_GET['Qid'])) {
            $Queues = $_GET['Qid'];
        }
        $res = $this->getAgentForProjectDID($project, $DID, $Queues);
        echo json_encode($res);
    }

    public function getWorkhours() {
        $project = "";
        $DID = "";
        $Queues = "";
        if (isset($_GET['project'])) {
            $project = $_GET['project'];
        }
        if (isset($_GET['did'])) {
            $DID = $_GET['did'];
        }
        if (isset($_GET['Qid'])) {
            $Queues = $_GET['Qid'];
        }
        $res = $this->getWorkhoursX($project, $DID, $Queues);
        if (!empty($res)) {
            $res = $res[0];
            if (!empty($res['timeStart'])) {

                $res['timeStart'] = $this->retime($res['timeStart']);
            }
            if (!empty($res['timeEnd'])) {
                $res['timeEnd'] = $this->retime($res['timeEnd']);
            }
            if (!empty($res['TotalWorkHours'])) {
                $res['TotalWorkHours'] = $this->retime($res['TotalWorkHours']);
            }
            if (!empty($res['TotalLunchHours'])) {
                $res['TotalLunchHours'] = $this->retime($res['TotalLunchHours']);
            }
        }
        echo json_encode($res);
    }

    public function getScore() {
        if (isset($_GET['project'])) {
            $did = $this->getProject($_GET['project']);
            echo json_encode($did);
        }
    }

    public function checkAuxNumber() {

        if (!empty($_GET['aid']) && !empty($_GET['aux'])) {
            $sql = "SELECT * FROM Auxtype WHERE aux_number='{$_GET['aux']}' AND aux_id != '{$_GET['aid']}'";
            if (!empty($this->query($sql))) {
                echo 1;
            }
        } else if (!empty($_GET['aux'])) {
            $sql = "SELECT * FROM Auxtype WHERE aux_number='{$_GET['aux']}'";
            if (!empty($this->query($sql))) {
                echo 1;
            }
        }
    }

}

$op = $_GET['op'];
$m = new op_ajax();
$m->$op();
