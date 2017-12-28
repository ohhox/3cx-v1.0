<?php

class functionx extends Crud {

    public function __construct() {
        parent::__construct();
    }

    public $dayNight = array(
        0 => 'Day',
        1 => 'Night',
        'all' => 'all'
    );

    public function s($ar) {
        echo "<pre>";
        print_r($ar);
        echo "</pre>";
    }

    public function test() {
        $this->pk = "AuxID";
        $this->table = "AuxTime";
        return $this->search(array('Agent' => '9003'));
    }

    public function getCallBack() {

        $where = "";
        $stardate = "";
        $enddate = "";

        $d = array(); // FOR SHOW IN INPUT
        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $date = explode('-', $_GET['date']);

            $stardate = trim($date[2] + 543) . '-' . $date[1] . '-' . $date[0];
            $enddate = trim($date[5] + 543) . '-' . $date[4] . '-' . ltrim(trim($date[3]));
            $d = array(
                '1' => $date[0] . '-' . $date[1] . '-' . trim($date[2]),
                '2' => ltrim(trim($date[3])) . '-' . $date[4] . '-' . ltrim(trim($date[5])),
            );
        } else {
            $enddate = $stardate = date('Y-m-d');
            $d = array(
                '1' => date('d-m-Y'),
                '2' => date('d-m-Y'),
            );
        }

        $where .= " WHERE convert(datetime, c.DateLeave) BETWEEN '$stardate' AND '$enddate' ";

///////////////////// PROJECT
        if (isset($_GET['Project']) && !empty($_GET['Project']) && $_GET['Project'] != "all") {
            $where .= " AND d.ProjectID='{$_GET['Project']}'";
        }
///////////////////// Queue
        if (isset($_GET['Queue']) && !empty($_GET['Queue']) && $_GET['Queue'] != "all") {
            $where .= " AND c.FromQueue='{$_GET['Queue']}'";
        }

        ///////////////////// Did
        if (isset($_GET['Did']) && !empty($_GET['Did']) && $_GET['Queue'] != "all") {
            $where .= " AND c.Project='{$_GET['Did']}'";
        }

///////////////////// DayOrNight
        if (isset($_GET['DayOrNight']) && $_GET['DayOrNight'] != "all") {
            $don = $_GET['DayOrNight'] - 1;
            $where .= " AND c.DayOrNight='{$don}'";
        }

///////////////////// LeaveNum
        if (isset($_GET['Leave']) && !empty($_GET['Leave']) && $_GET['Leave'] == "1") {
            $where .= " AND c.LeaveNum !=''";
        }

        $sql = " SELECT  convert(date, c.DateLeave) as  DateLeave , c.TimeLeave, c.CallNum,c.LeaveNum,c.FromQueue,c.Project "
                . " FROM CallBack AS c"
                . " LEFT JOIN DIDQueues AS d ON d.DIDNumber = c.Project "
                . "$where";
        return $this->query($sql);
    }

    public function getEndCall() {

        $where = "";
        $stardate = "";
        $enddate = "";

        $d = array(); // FOR SHOW IN INPUT
        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $date = explode('-', $_GET['date']);

            $stardate = trim($date[2]) . '-' . $date[1] . '-' . $date[0];
            $enddate = trim($date[5]) . '-' . $date[4] . '-' . $date[3];
            $d = array(
                '1' => $date[0] . '-' . $date[1] . '-' . trim($date[2]),
                '2' => $date[3] . '-' . $date[4] . '-' . trim($date[5]),
            );
        } else {
            $enddate = $stardate = date('Y-m-d');
            $d = array(
                '1' => date('d-m-Y'),
                '2' => date('d-m-Y'),
            );
        }

        $where .= " WHERE convert(datetime, date) BETWEEN '$stardate' AND '$enddate' ";

///////////////////// PROJECT
        if (isset($_GET['Project']) && !empty($_GET['Project']) && $_GET['Project'] != "all") {
            $where .= " AND project='{$_GET['Project']}'";
        }
///////////////////// Queue
        if (isset($_GET['Queue']) && !empty($_GET['Queue']) && $_GET['Queue'] != "all") {
            $where .= " AND agent='{$_GET['Queue']}'";
        }

        if (isset($_GET['scorestrat']) && isset($_GET['scoreend'])) {
            $where .= " AND  score BETWEEN '{$_GET['scorestrat']}' AND '{$_GET['scoreend']}'";
        } else {
            $where .= " AND  score BETWEEN '1' AND '5'";
        }


        $sql = "SELECT  convert(date, date) as DateLeave , convert(time,time) as  time, customernumber,agent,score FROM endcall $where";
        return $this->query($sql);
    }

    public function getCallBackAgent() {
        $sql = "SELECT FromQueue FROM CallBack GROUP BY FromQueue";
        return $this->query($sql);
    }

    public function getCallBackProject() {
        $sql = "SELECT Project FROM CallBack WHERE Project !='' GROUP BY Project";
        return $this->query($sql);
    }

    public function getProject($id) {
        $sql = "SELECT * FROM Projects WHERE ProjectID='$id' ";
        $res = $this->query($sql);
        if (!empty($res)) {
            return $res[0];
        } else {
            return array();
        }
    }

    public function getProjectList() {
        $sql = "SELECT * FROM Projects";
        return $this->query($sql);
    }

    public function getDid($project) {
        $sql = "SELECT * FROM DIDQueues WHERE ProjectID='$project'";
        return $this->query($sql);
    }

    public function getEndCallAgent() {
        $sql = "SELECT agent FROM endcall GROUP BY agent";
        return $this->query($sql);
    }

    public function getEndCallkProject() {
        $sql = "SELECT project AS Project FROM endcall WHERE project !='' GROUP BY project";
        return $this->query($sql);
    }

    public function redate($date, $plus = 'yes') {
        $date = explode('-', $date);
        if ($plus == 'yes') {
            return $date[2] . '-' . $date[1] . '-' . ($date[0] - 543);
        } else {
            return $date[2] . '-' . $date[1] . '-' . ($date[0]);
        }
    }

    public function retime($date) {
        $date = explode(':', $date);
        return $date[0] . ':' . $date[1];
    }

}
