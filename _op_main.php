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
        $data = $_POST;
        unset($data['DidDescription']);
        $res = $this->search($data);


        if (!empty($res)) {
            echo "1";
        } else {
            echo "2";
            $this->__setMultiple($_POST);
            $this->create();
            // $this->Go("manage_queses.php");
        }
    }

    public function editDidQueres() {
        $this->table = "DIDQueues";
        $this->pk = 'DIDQueueID';

        $data = $_POST;
        unset($data['DidDescription']);
        $res = $this->search($data);
        $erro = 1;
        foreach ($res as $key => $value) {
            if ($value['DIDQueueID'] != $_GET['id']) {
                $erro = 2;
                break;
            }
        }
        if ($erro == 1) {
            $this->__setMultiple($_POST);
            $this->save($_GET['id']);
            echo "2";
        } else {
            echo "1";
        }
        //$this->Go("manage_queses.php");
    }

    public function removeDidQueres() {
        $this->table = "DIDQueues";
        $this->pk = 'DIDQueueID';
        if (!empty($_GET['id'])) {
            $this->delete($_GET['id']);
        }
        $this->Go("manage_queses.php");
    }

    public function saveUser() {
        $this->table = "Users";
        $this->pk = 'user_id';
        $data = $this->toThaiText($_POST);
        $this->__setMultiple($data);
        $this->create();
        $this->Go("user_management.php");
    }

    public function editUser() {
        $this->table = "Users";
        $this->pk = 'user_id';
        $data = $this->toThaiText($_POST);
        $this->__setMultiple($data);
        $this->save($_GET['id']);
        $this->Go("user_management.php");
    }

    public function removeUser() {
        $this->table = "Users";
        $this->pk = 'user_id';

        if (!empty($_GET['id'])) {
            $array = array(
                'user_status' => 1
            );
            $this->__setMultiple($array);
            $this->save($_GET['id']);
        }
        $this->Go("user_management.php");
    }

    public function saveAgent() {
        $this->table = "agent";
        $this->pk = 'agent_id';
        $data = $this->toThaiText($_POST);
        $this->__setMultiple($data);
        $this->create();
        $this->Go("manage_agent.php");
    }

    public function editAgent() {
        $this->table = "agent";
        $this->pk = 'agent_id';
        $data = $this->toThaiText($_POST);
        $this->__setMultiple($data);
        $this->save($_GET['id']);
        $this->Go("manage_agent.php");
    }

    public function removeAgent() {
        $this->table = "agent";
        $this->pk = 'agent_id';

        if (!empty($_GET['id'])) {
            $array = array(
                'agent_status' => 1
            );
            $this->__setMultiple($array);
            $this->save($_GET['id']);
        }
        $this->Go("manage_agent.php");
    }

    public function saveAgentDid() {

        $this->table = "didagent";
        $this->pk = 'didagent_id';
        foreach ($_POST['agent_id'] as $key => $value) {
            $data = array(
                'DIDQueueID' => $_GET['id'],
                'agent_id' => $value
            );
            $this->__setMultiple($data);
            $this->create();
        }
        $this->Go("manage_did_agent.php?id=" . $_GET['id']);
    }

    public function removeDidAgent() {
        $this->table = "didagent";
        $this->pk = 'didagent_id';
        if (!empty($_GET['id']) && !empty($_GET['didid'])) {
            $sql = "DELETE FROM didagent WHERE agent_id='{$_GET['id']}' AND DIDQueueID='{$_GET['didid']}'";
            $this->query($sql);
        }
        $this->Go("manage_did_agent.php?id=" . $_GET['didid']);
    }

}

$op = $_GET['op'];
$m = new op_main();
$m->$op();
