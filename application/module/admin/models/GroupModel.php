<?php
    class GroupModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        //To pagination
        public function countItem($params){

            $query[] 		= "SELECT COUNT(`id`) AS 'totalItem'";
			$query[] 		= "FROM `group`";
            $query[]		= "WHERE `id` > 0";

            //TYPING SEARCH
            if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
                if($params["filter_typing"] == "all"){
                    $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `group_descript` LIKE '%".$params["content_search"]."%' ";
                }else{
                    $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                }
            }

            //SELECT SEARCH
            if(isset($params["filter_name_group"])){
                if($params["filter_name_group"] != "default"){
                    $query[] = "AND `id` = '$params[filter_name_group]'";
                }
            }
            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND `status` = '$params[select_filter_status]'";
                }
            }

             //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }

            $query = implode(" ", $query);

            return $this->fetchRow($query);

        }

        public function listItem($params){

            $query[] 		= "SELECT `id`, `name`, `group_acp`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`, `group_descript` ";
			$query[] 		= "FROM `group`";
            $query[]		= "WHERE `id` > 0";

            //TYPING SEARCH
            if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
                if($params["filter_typing"] == "all"){
                    $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `group_descript` LIKE '%".$params["content_search"]."%' ";
                }else{
                    $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                }
            }

            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND `status` = '$params[select_filter_status]'";
                }
            }
            if(isset($params["filter_acp"])){
                if($params["filter_acp"] != "default"){
                    $query[] = "AND `group_acp` = '$params[filter_acp]'";
                }
            }

            //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }else{
                $query[]    = "ORDER BY `id` ASC";
            }

            //PAGINATION
			$pagination 		= $params["pagination"];
			$totalItemPerPage 	= $pagination["totalItemPerPage"];
			if($totalItemPerPage > 0){
				$position	= ($params["pagination"]["currentPage"]-1)*$totalItemPerPage;
				$query[]	= "LIMIT $position, $totalItemPerPage";
			}

            $query = implode(" ", $query);

            return $this->fetchAll($query);

        }

        public function listGroup($params){
            $query[] 		= "SELECT `id`, `name`";
			$query[] 		= "FROM `group`";
            $query[]		= "WHERE `id` > 0";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        public function infoItem($params){
            $query = "SELECT * FROM `group` WHERE id = $params[id]";
            return $this->fetchRow($query);
        }

        //Ajax check form
        public function ajaxCheckForm($params){
            $query = "SELECT id FROM `$params[table]` WHERE name = '$params[valueCheck]'";

            //Edit
            if(isset($params["id"])){
                if($params["id"] > 0){
                    $query .= "AND `id` != " . $params["id"];
                }
            }
            
            if( $this->isExists($query) ){
                echo json_encode(array("check_status" => 0));
            }else{
                echo json_encode(array("check_status" => 1));
            }
        }

        //Add new group
        public function insertGroup($params){
            if(!empty($params)){
                $params["created"]      = date("Y-m-d H:i:s", time());
                $params["created_by"]   = $this->_userInfoInSession["username"];
                $query                  = $this->createInsertSql($params, "`group`");
                return $countRowAffected= $this->insertSql($query);
            }
        }

        //Update group
        public function updateGroup($params){
            if(!empty($params)){
                $params["modified"]      = date("Y-m-d H:i:s", time());
                $params["modified_by"]   = $this->_userInfoInSession["username"];
                $query                   = $this->createUpdateSql($params, "`group`");
                return $countRowAffected = $this->insertSql($query);
            }
        }

        //Delete multi group
        public function deleteMulti($params){
            if(!empty($params["multi_select"])){
                $query      = $this->createDeleteSql($params["multi_select"], "`group`", array("condition" => "id"));
                return $this->executeAndReturnAffectedRows($query);
            }
        }


        //Ajax change status
        public function ajaxChangeStatus($params){
            $statusUpdate  = $params["valueUpdateTo"];
            $elementUpdate = $params["elementUpdateStatus"];
            $query         = "UPDATE `group` SET $elementUpdate = '$statusUpdate' WHERE id = $params[id_update]";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $link          = ($statusUpdate == 1)? Helper::createPublicLink(array("element" => $elementUpdate, "id" => $params["id_update"])) : Helper::createUnpublicLink(array("element" => $elementUpdate, "id" =>  $params["id_update"]));
            $arrayReturn   = array(
                                    "affectedRows"  => $affectedRows,
                                    "elementUpdate" => $elementUpdate,
                                    "statusUpdate"  => $statusUpdate,
                                    "idUpdate"      => $params["id_update"],
                                    "link"          => $link
                                );
            echo json_encode( $arrayReturn );
        }

        //Ajax Change Ordering
        public function ajaxChangeOrdering($params){
            $orderingUpdate= $params["valueUpdateTo"];
            $query         = "UPDATE `group` SET ordering = '$orderingUpdate' WHERE id = $params[id_update]";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $arrayReturn   = array(
                "orderingUpdate" => $orderingUpdate,
                "idUpdate"       => $params["id_update"],
            );
            echo json_encode( $arrayReturn );
        }

        //MULTI PUBLIC
        public function multiPublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `group` SET `status` = 1 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }
        
        //MULTI UN PUBLIC
        public function multiUnpublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `group` SET `status` = 0 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }

    }