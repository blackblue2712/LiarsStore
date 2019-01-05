<?php
    class AnalyticsModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        public function totalAmoutInAll(){
            $query = "SELECT prices, `date` FROM cart WHERE `status` = 1";
            return $this->fetchAll($query);
        }

        public function totalAmoutInDay(){
            $today = date('Y-m-d', time()) ;
            $query = "SELECT prices FROM cart WHERE `status` = 1 AND (`date` BETWEEN '$today 00:00:00' AND '$today 23:59:59')";
            return $this->fetchAll($query);
        }

        public function totalAmoutInWeek(){
            $startdate      = strtotime("Monday");
            if($startdate > time()) $startdate -= 86400*7;
            $strStartdate   = date("Y-m-d H:i:s", $startdate);
            $enddate        = strtotime("Sunday");
            $strEnddate     = date("Y-m-d H:i:s", $enddate+86399);
            $query = "SELECT prices FROM cart WHERE `status` = 1 AND (`date` BETWEEN '$strStartdate' AND '$strEnddate')";
            return $this->fetchAll($query);
        }
    }
?>