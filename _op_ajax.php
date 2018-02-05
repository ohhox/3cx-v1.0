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
        } 
        echo json_encode($res);
    }

    public function getScore() {
        if (isset($_GET['project'])) {
            $did = $this->getProject($_GET['project']);
            echo json_encode($did);
        }
    }

}

$op = $_GET['op'];
$m = new op_ajax();
$m->$op();
