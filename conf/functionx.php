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

    public function Go($link) {
        header("Location: $link");
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
            $enddate = trim($date[5]) . '-' . $date[4] . '-' . ltrim(trim($date[3]));
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

        $where .= " WHERE convert(datetime, c.date) BETWEEN '$stardate' AND '$enddate' ";

///////////////////// PROJECT
        if (isset($_GET['Project']) && !empty($_GET['Project']) && $_GET['Project'] != "all") {
            $where .= " AND d.ProjectID='{$_GET['Project']}'";
        }
///////////////////// Queue
        if (isset($_GET['Queue']) && !empty($_GET['Queue']) && $_GET['Queue'] != "all") {
            $where .= " AND d.QueueNumber='{$_GET['Queue']}'";
        }

        ///////////////////// Did
        if (isset($_GET['Did']) && !empty($_GET['Did']) && $_GET['Did'] != "all") {
            $where .= " AND c.project='{$_GET['Did']}'";
        }

///////////////////// DayOrNight
        if (isset($_GET['Agent']) && !empty($_GET['Agent']) && $_GET['Agent'] != "all") {
            $where .= " AND c.agent='{$_GET['Agent']}'";
        }

///////////////////// LeaveNum
        if (isset($_GET['Leave']) && !empty($_GET['Leave']) && $_GET['Leave'] == "1") {
            $where .= " AND c.LeaveNum !=''";
        }

        $sql = " SELECT  convert(date, c.date) as  DateLeave, c.time, c.project,c.customernumber,c.agent,c.score,d.DIDNumber,d.QueueNumber "
                . " FROM endcall AS c"
                . " LEFT JOIN DIDQueues AS d ON d.DIDNumber = c.project "
                . "$where";
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

    public function getProject($id = '') {
        $where = "";
        if (!empty($id)) {
            $sql = "SELECT * FROM Projects WHERE ProjectID='$id' ";

            $res = $this->query($sql);
            if (!empty($res)) {
                return $res[0];
            } else {
                return array();
            }
        } else {
            $sql = "SELECT * FROM Projects ";

            return $this->query($sql);
        }
    }

    public function getDIDQueues($id = '') {
        $where = "";
        if (!empty($id)) {
            $sql = "SELECT d.*,j.Name,j.Code FROM DIDQueues AS  d"
                    . " LEFT JOIN Projects AS j ON j.ProjectID=d.ProjectID"
                    . " WHERE d.DIDQueueID='$id' ";

            $res = $this->query($sql);
            if (!empty($res)) {
                return $res[0];
            } else {
                return array();
            }
        } else {
            $wh = '';
            if (isset($_GET['text']) & !empty($_GET['text'])) {
                $text = $_GET['text'];
                $wh = " WHERE j.Name LIKE '%$text%' OR  d.DIDNumber LIKE '%$text%' OR  d.QueueNumber LIKE '%$text%'";
            }
            $sql = "SELECT d.*,j.Name,j.Code  FROM DIDQueues AS  d"
                    . " LEFT JOIN Projects AS j ON j.ProjectID=d.ProjectID  $wh";

            return $this->query($sql);
        }
    }

    public function getProjectList() {
        $sql = "SELECT * FROM Projects";
        return $this->query($sql);
    }

    public function getDid($project) {
        $sql = "SELECT DIDNumber FROM DIDQueues WHERE ProjectID='$project' GROUP BY DIDNumber";
        return $this->query($sql);
    }

    public function getQueue($didnumber) {
        $sql = "SELECT QueueNumber FROM DIDQueues WHERE DIDNumber='$didnumber' GROUP BY QueueNumber";
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

    public function getUser($id = '') {
        $where = "";
        if (!empty($id)) {
            $sql = "SELECT * FROM Users WHERE user_id='$id'";

            $res = $this->query($sql);
            if (!empty($res)) {
                return $res[0];
            } else {
                return array();
            }
        } else {
            $wh = '';
            if (isset($_GET['text']) & !empty($_GET['text'])) {
                $get = $this->toThaiText($_GET);
                $text = $get['text'];
                $wh = " AND (name_lastname LIKE '%$text%' OR  username LIKE '%$text%' OR email LIKE '%$text%')";
            }
            $sql = "SELECT * FROM Users WHERE user_status = '0' $wh";

            return $this->query($sql);
        }
    }

    public function getAgent($id = NULL) {
        $where = "";
        if (!empty($id)) {
            $sql = "SELECT * FROM agent WHERE agent_id='$id'";

            $res = $this->query($sql);
            if (!empty($res)) {
                return $res[0];
            } else {
                return array();
            }
        } else {
            $wh = '';
            if (isset($_GET['text']) & !empty($_GET['text'])) {
                $get = $this->toThaiText($_GET);
                $text = $get['text'];
                $wh = " AND (agent_code LIKE '%$text%' OR  name LIKE '%$text%' OR lastname LIKE '%$text%' OR tel LIKE '%$text%')";
            }
            $sql = "SELECT * FROM agent WHERE  agent_status='0' $wh";

            return $this->query($sql);
        }
    }

    public function toThaiText(array $data) {
        $res = array();
        foreach ($data as $key => $value) {
            $res[$key] = iconv('windows-874', 'utf-8', $value);
        }
        return $res;
    }

    public function ThaiTextToutf(array $data) {
        $res = array();
        foreach ($data as $key => $value) {
            $res[$key] = iconv('utf-8', 'windows-874', $value);
        }
        return $res;
    }

    public function getDidAgent($id) {
      echo  $sql = " SELECT dq.DIDNumber,dq.QueueNumber,a.* FROM didagent AS d "
                . "LEFT JOIN agent AS a ON a.agent_id=d.agent_id "
                . "LEFT JOIN DIDQueues AS dq ON dq.DIDQueueID=d.DIDQueueID "
                . "WHERE  d.DIDQueueID='$id'";
        return $this->query($sql);
    }

    public function getNotDidAgent($id) {
        $sql = "SELECT *  FROM agent WHERE agent_id NOT IN( SELECT agent_id FROM didagent WHERE DIDQueueID='$id') AND agent_status='0'";
        return $this->query($sql);
    }

    public function countDidAgent($id) {
        $sql = "SELECT count(*) AS count FROM didagent WHERE  DIDQueueID='$id'";
        $res = $this->query($sql);
        return $res[0]['count'];
    }

}
