<?php

include './conf.php';

class system extends functionx {

    function __construct() {
        parent::__construct();
    }

    public function login() {
        $this->table = "Users";
        $this->pk = "user_id";
        if (!empty($_POST)) {
            $this->s($_POST);
            if (!empty($_POST['loginUsername']) && !empty($_POST['loginPassword'])) {
                $res = $this->search(array(
                    "username" => $_POST['loginUsername'],
                    "password" => $_POST['loginPassword']
                ));

                if (empty($res)) {
                    $this->Go('login.php?er=nof');
                } else {
                    setcookie("uid", $res[0]['user_id'], time() + (60 * 60 * 24 * 7 ));
                     $this->Go('index.php');
                }
            }
        }
    }

}

$fn = new system();
$fn->$_GET['op']();
