<?php

class functionx extends Crud {

    public $user = array();
    private $allow_file = array(
        'login.php',
        'system.php'
    );

    public function __construct() {
        parent::__construct();
        if (isset($_COOKIE['uid']) && !empty($_COOKIE['uid'])) {
            $user = $this->getUser($_COOKIE['uid']);
            if (empty($user)) {
                $this->checkLogin();
            } else {
                if ($user['user_status'] != 0) {
                    $this->checkLogin();
                } else {
                    $this->user = $user;
                }
            }
        } else {
            $this->checkLogin();
        }
    }

    public $dayNight = array(
        1 => 'Day',
        2 => 'Night',
        'all' => 'all'
    );

    public function checkLogin() {


        $file = $_SERVER['SCRIPT_NAME'];
        $file = str_repeat('/', "", $file);
        if (!in_array($file, $this->allow_file)) {
            $this->Go('logout.php');
        }
    }

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
        if (isset($_GET['Did']) && !empty($_GET['Did']) && $_GET['Did'] != "all") {
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
                . " LEFT JOIN DIDQueues AS d ON d.DIDNumber = c.Project AND d.QueueNumber=c.FromQueue"
                . "$where "
                . " ORDER BY convert(date, c.DateLeave) ASC , convert(time,TimeLeave) ASC";
        return $this->query($sql);
    }

    public function getEndCall() {

        $where = "";
        $where2 = "";
        $where3 = "";
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

        if (!isset($_GET['Project']) || $_GET['Project'] == "all" || empty($_GET['Project'])) {
            return array();
        }

        $where .= " AND convert(datetime, c.date) BETWEEN '$stardate' AND '$enddate' ";
        $where2 .= " WHERE convert(datetime, date) BETWEEN '$stardate' AND '$enddate' ";
///////////////////// PROJECT
        if (isset($_GET['Project']) && !empty($_GET['Project']) && $_GET['Project'] != "all") {
            $where .= " AND d.ProjectID='{$_GET['Project']}'";
            $where3 .= " AND d.ProjectID='{$_GET['Project']}'";
        }
///////////////////// Queue
        if (isset($_GET['Queue']) && !empty($_GET['Queue']) && $_GET['Queue'] != "all") {
            $where .= " AND d.QueueNumber='{$_GET['Queue']}'";
        }

        ///////////////////// Did
        if (isset($_GET['Did']) && !empty($_GET['Did']) && $_GET['Did'] != "all") {
            $where .= " AND  d.DIDNumber='{$_GET['Did']}'";
            $where2 .= " AND  project='{$_GET['Did']}'";
            $where3 .= " AND d.DIDNumber='{$_GET['Did']}'";
        }

///////////////////// Agent
        if (isset($_GET['Agent']) && !empty($_GET['Agent']) && $_GET['Agent'] != "all") {
            $where .= " AND c.agent='{$_GET['Agent']}'";
            $where3 .= " AND a.agent_code='{$_GET['Agent']}'";
        }

///////////////////// LeaveNum
        if (isset($_GET['Leave']) && !empty($_GET['Leave']) && $_GET['Leave'] == "1") {
            $where .= " AND c.LeaveNum !=''";
        }
        ///////////////////// Score
        if (isset($_GET['scorestrat']) && isset($_GET['scoreend']) && !isset($_GET['scoreNull'])) {
            $where .= " AND c.score BETWEEN {$_GET['scorestrat']} AND {$_GET['scoreend']}";
            $where2 .= " AND score BETWEEN {$_GET['scorestrat']} AND {$_GET['scoreend']}";
        }


        if (isset($_GET['dialin']) && $_GET['dialin'] != 'ALL') {
            $where .= " AND c.Dialin='{$_GET['dialin']}'";
            $where2 .= " AND Dialin='{$_GET['dialin']}'";
        }

        if (isset($_GET['scoreNull'])) {
            $where .= " AND(c.score IS NULL)";
        }


        if (isset($_GET['timeStart'])) {
            if (isset($_GET['timeEnd']) && !empty($_GET['timeEnd'])) {
                if ($_GET['timeEnd'] == "24:00")
                    $_GET['timeEnd'] = "23:59";
                $where .= " AND convert(time,  c.time) BETWEEN '{$_GET['timeStart']}' AND '{$_GET['timeEnd']}'";
                $where2 .= " AND convert(time,time) BETWEEN '{$_GET['timeStart']}' AND '{$_GET['timeEnd']}'";
                //convert(time,  c.time) BETWEEN '00:00' AND '23:59'
            }
        }


        if (isset($_GET['report']) && !empty($_GET['report']) && $_GET['report'] == 'sum') { // Average
            if (isset($_GET['calc']) && !empty($_GET['calc']) && $_GET['calc'] == 'all') { // ALL Agent
                $sql = ""
                        . "SELECT  name,lastname,agent_code AS agent,DIDNumber,score  FROM (
                        (
                        SELECT a.agent_code,d.DIDNumber,a.name,a.lastname  
                            FROM didagent AS da
                            LEFT JOIN agent AS a ON a.agent_id =da.agent_id
                            LEFT JOIN DIDQueues AS d ON d.DIDQueueID = da.DIDQueueID  
                            WHERE  a.agent_status='0' $where3
                         GROUP BY a.agent_code,d.DIDNumber,a.name,a.lastname
                          ) AS data1 
                          LEFT JOIN (
                                SELECT ROUND(AVG(CAST(score AS FLOAT)), 2) as score,agent,project as did   
                                FROM  endcall 
                                 $where2  
                                 GROUP BY agent,project
                          ) AS data2 ON data1.agent_code = data2.agent  AND data1.DIDNumber= data2.did
                          )
                          ORDER BY agent_code ASC
                    ";
            } else {
                $sql = "SELECT ROUND(AVG(CAST(c.score AS FLOAT)), 2)  as score,a.agent_code as agent,d.DIDNumber as DIDNumber,a.name,a.lastname
                    FROM didagent AS da
                    LEFT JOIN agent AS a ON a.agent_id =da.agent_id
                    LEFT JOIN DIDQueues AS d ON d.DIDQueueID = da.DIDQueueID 
                    LEFT JOIN endcall AS c ON c.agent = a.agent_code  AND c.project = d.DIDNumber
                    WHERE  a.agent_status='0' "
                        . "$where "
                        . " GROUP BY a.agent_code,d.DIDNumber,a.name,a.lastname "
                        . "";
            }
        } else {

            if (isset($_GET['Cusnum']) && !empty($_GET['Cusnum'])) {
                $where .= " AND customernumber LIKE '%{$_GET['Cusnum']}%'";
            }
            $sql = " SELECT convert(date, c.date) as  DateLeave, c.time, c.project,c.customernumber,c.agent,c.score,d.DIDNumber,d.QueueNumber,a.name,a.lastname
                    FROM didagent AS da
                    LEFT JOIN agent AS a ON a.agent_id =da.agent_id
                    LEFT JOIN DIDQueues AS d ON d.DIDQueueID = da.DIDQueueID  
                    LEFT JOIN endcall AS c ON c.agent = a.agent_code  AND c.project = d.DIDNumber
                    WHERE  a.agent_status='0' "
                    . "$where "
                    . " ORDER BY convert(date, c.date) ASC , convert(time,c.time) ASC";
        }

        return $this->query($sql);
    }

    public function getAuxtime() {
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

        $sqlGETAGENTID = "
                SELECT a.agent_code
                FROM didagent AS da  
                LEFT JOIN DIDQueues AS dq ON dq.DIDQueueID=da.DIDQueueID 
                LEFT JOIN agent AS a ON da.agent_id=a.agent_id 
                WHERE  ";



        if (!isset($_GET['Project']) || $_GET['Project'] == "all" || empty($_GET['Project'])) {
            return array();
        }
        if (isset($_GET['Project']) && !empty($_GET['Project']) && $_GET['Project'] != "all") {
            $sqlGETAGENTID .= " dq.ProjectID='{$_GET['Project']}'";
        }
        ///////////////////// Queue
        if (isset($_GET['Queue']) && !empty($_GET['Queue']) && $_GET['Queue'] != "all") {
            $sqlGETAGENTID .= " AND dq.QueueNumber='{$_GET['Queue']}'";
        }

        ///////////////////// Did
        if (isset($_GET['Did']) && !empty($_GET['Did']) && $_GET['Did'] != "all") {
            $sqlGETAGENTID .= " AND   dq.DIDNumber='{$_GET['Did']}'";
        }

        ///////////////////// Agent
        if ($_GET['agentOption'] == 'number') {
            if (isset($_GET['Agent']) && !empty($_GET['Agent']) && $_GET['Agent'] != "all") {
                $sqlGETAGENTID .= " AND a.agent_code='{$_GET['Agent']}'";
            }
        } else {

            if (isset($_GET['Cusnum']) && !empty($_GET['Cusnum'])) {
                $text = rtrim(ltrim(trim($_GET['Cusnum'])));
                $sqlGETAGENTID .= " AND(a.name LIKE '%{$text}%' OR lastname LIKE '%{$text}%')";
            }
        }


        $where = "WHERE ax.Agent IN($sqlGETAGENTID) AND  DATEADD(year,-543,convert(date,ax.DateAux)) BETWEEN '$stardate' AND '$enddate' ";
        if (isset($_GET['timeOption'])) {
            if (isset($_GET['timeStart']) && $_GET['timeOption'] == 'Custom') {
                if (isset($_GET['timeEnd']) && !empty($_GET['timeEnd'])) {
                    if ($_GET['timeEnd'] == "24:00")
                        $_GET['timeEnd'] = "23:59";
                    $where .= " AND convert(time,  ax.TimeAux) BETWEEN '{$_GET['timeStart']}' AND '{$_GET['timeEnd']}'";
                }
            }else if (isset($_GET['whs']) && $_GET['timeOption'] == 'whTime') {
                if (isset($_GET['whe']) && !empty($_GET['whe'])) {
                    if ($_GET['whe'] == "24:00")
                        $_GET['whe'] = "23:59";
                    $where .= " AND convert(time,  ax.TimeAux) BETWEEN '{$_GET['whs']}' AND '{$_GET['whe']}'";
                }
            }
        }

        if (isset($_GET['aux']) && ($_GET['aux'] != 'all')) {
            $where .= " AND ax.AuxNum='{$_GET['aux']}'";
        }

        $sql = "SELECT *,convert(date, DateAux) as  date FROM AuxTime AS ax LEfT JOIN agent AS a ON a.agent_code=ax.Agent  $where ";
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
            $sql = "SELECT d.*,j.Name,j.Code "
                    . " FROM DIDQueues AS  d"
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
        $sql = " SELECT dq.DIDNumber,dq.QueueNumber,a.* FROM didagent AS d "
                . "LEFT JOIN agent AS a ON a.agent_id=d.agent_id "
                . "LEFT JOIN DIDQueues AS dq ON dq.DIDQueueID=d.DIDQueueID "
                . "WHERE  d.DIDQueueID='$id' ORDER BY a.agent_code ASC";
        return $this->query($sql);
    }

    public function getNotDidAgent($id) {
        $sql = "SELECT *  FROM agent WHERE agent_id NOT IN(SELECT agent_id FROM didagent WHERE DIDQueueID='$id') AND agent_status='0' ORDER BY agent_code ASC";
        return $this->query($sql);
    }

    public function countDidAgent($id) {
        $sql = "SELECT count(*) AS count FROM didagent WHERE  DIDQueueID='$id'";
        $res = $this->query($sql);
        return $res[0]['count'];
    }

    public function getAgentForProjectDID($project = "", $did = "", $queues = "") {
        $sql = "SELECT agent_code FROM didagent AS da"
                . " LEFT JOIN agent AS a ON a.agent_id=da.agent_id "
                . " LEFT JOIN DIDQueues AS d ON d.DIDQueueID=da.DIDQueueID "
                . " WHERE a.agent_status='0'  ";
        if ($project != "all" && !empty($project)) {
            $sql .= " AND d.ProjectID='$project'";
        }
        if ($did != "all" && !empty($did)) {
            $sql .= " AND d.DIDNumber='$did'";
        }
        if ($queues != "all" && !empty($queues)) {
            $sql .= " AND d.QueueNumber='$queues'";
        }
        $sql .= ' GROUP BY  agent_code ORDER BY agent_code';
        return $this->query($sql);
    }

    public function getWorkhoursX($project = "", $did = "", $queues = "") {
        if (empty($project) || empty($did) || empty($queues)) {
            return array();
        } else {
            $sql = "SELECT * FROM DIDQueues WHERE ProjectID='$project' AND DIDNumber='$did' AND QueueNumber='$queues'";
            return $this->query($sql);
        }
    }

    public function getAuxType($id = 0) {
        $this->table = "Auxtype";
        $this->pk = 'aux_id';
        if (!empty($id)) {
            $sql = "SELECT * FROM Auxtype WHERE aux_id='$id'";
            $res = $this->query($sql);
            if (!empty($res)) {
                return $res[0];
            } else {
                return array();
            }
        } else {
            $w = "";
            if (isset($_GET['text']) && !empty($_GET['text'])) {
                $w .= " AND (aux_number LIKE '%{$_GET['text']}%' OR aux_description LIKE '%{$_GET['text']}%')";
            }
            $sql = "SELECT * FROM Auxtype WHERE status !='1' $w ORDER BY aux_number ASC ";
            return $this->query($sql);
        }
    }

}
