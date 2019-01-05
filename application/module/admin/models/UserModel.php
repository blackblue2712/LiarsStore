<?php
    class UserModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        //To pagination
        public function countItem($params){

            $query[] 		= "SELECT COUNT(`id`) AS 'totalItem'";
			$query[] 		= "FROM `user`";
            $query[]		= "WHERE `id` > 0";

            //TYPING SEARCH
            // if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
            //     if($params[K!"filter_typing"] == "all"){
            //         $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `group_descript` LIKE '%".$params["content_search"]."%' ";
            //     }else{
            //         $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
            //     }
            // }

            //SELECT SEARCH
            if(isset($params["select_filter_group"])){
                if($params["select_filter_group"] != "default"){
                    $query[] = "AND `group_id` = '$params[select_filter_group]'";
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

            $query[] 		= "SELECT u.`id`, u.`username`, u.`avatar`, u.`email`, u.`fullname`, u.`status`, u.`ordering`, u.`created`, u.`created_by`, u.`modified`, u.`modified_by`, u.`user_descript`, g.`name` AS `group_name` ";
			$query[] 		= "FROM `user` AS u LEFT JOIN `group` AS g";
			$query[] 		= "ON u.`group_id` = g.`id`";
            $query[]		= "WHERE u.`id` > 0";

            // TYPING SEARCH
            if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
                if($params["filter_typing"] == "all"){
                    $query[] = "AND u.`username` LIKE '%".$params["content_search"]."%' OR `user_descript` LIKE '%".$params["content_search"]."%' ";
                }else{
                    $query[] = "AND u.`$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                }
            }

            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND u.`status` = '$params[select_filter_status]'";
                }
            }
            if(isset($params["select_filter_group"])){
                if($params["select_filter_group"] != "default"){
                    $query[] = "AND u.`group_id` = '$params[select_filter_group]'";
                }
            }

            //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }else{
                $query[]    = "ORDER BY u.`id` ASC";
            }

            //PAGINATION
			$pagination 		= $params["pagination"];
			$totalItemPerPage 	= $pagination["totalItemPerPage"];
			if($totalItemPerPage > 0){
				$position	= ($params["pagination"]["currentPage"]-1)*$totalItemPerPage;
				$query[]	= "LIMIT $position, $totalItemPerPage";
			}

            $query = implode(" ", $query);

            return $this->fetchAllKeyIsID($query);

        }

        public function listUser($params){
            $query[] 		= "SELECT `id`, `username`";
			$query[] 		= "FROM `user`";
            $query[]		= "WHERE `id` > 0";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        public function listGroup($params){
            $query[] 		= "SELECT `id`, `name`";
			$query[] 		= "FROM `group`";
            $query[]		= "WHERE `status` = 1";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        public function infoItem($params){
            $query = "SELECT * FROM `user` WHERE id = $params[id]";
            return $this->fetchRow($query);
        }

        //Ajax check form
        public function ajaxCheckForm($params){
            $query = "SELECT id FROM `$params[table]` WHERE $params[colCheck] = '$params[valueCheck]'";

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

        //Add new user
        public function insertUser($params){
            if(!empty($params)){
                $params["created"]      = date("Y-m-d H:i:s", time());
                $params["created_by"]   = $this->_userInfoInSession["username"];
                $params["register_ip"]  = $_SERVER["SERVER_ADDR"];
                $params["username"]     = mysqli_escape_string($this->_connect, $params["username"]);
                $params["email"]        = mysqli_escape_string($this->_connect, $params["email"]);
                $params["user_descript"]= mysqli_escape_string($this->_connect, $params["user_descript"]);
                $params["group_id"]     = mysqli_escape_string($this->_connect, $params["group_id"]);
                $params["avatar"]     = mysqli_escape_string($this->_connect, $params["picture"]);
                unset($params["picture"]);

                $query                  = $this->createInsertSql($params, "`user`");
                return $countRowAffected= $this->insertSql($query);
            }
        }

        //Update user
        public function updateUser($params){
            if(!empty($params)){
                if(isset($params["form"]["picture"])){
                    include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                    $upload             = new Upload();
                    $querySelectPicture = "SELECT `id`, `avatar` AS `name` FROM `user` WHERE `id` IN ($params[id])";
                    $picture            = $this->fetchRow($querySelectPicture);
                    $upload->removeFile("user", $picture["name"], 98, 150);
                }
                $params["form"]["modified"]      = date("Y-m-d H:i:s", time());
                $params["form"]["modified_by"]   = $this->_userInfoInSession["username"];
                if(isset($params["form"]["picture"])){
                    $params["form"]["avatar"]        = mysqli_escape_string($this->_connect, @$params["form"]["picture"]);
                    unset($params["form"]["picture"]);
                }
                $query                   = $this->createUpdateSql($params, "`user`");
                return $countRowAffected = $this->insertSql($query);
            }
        }

        //Delete multi user
        public function deleteMulti($params){
            include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
            $upload         = new Upload();
            if(!empty($params["multi_select"])){
                $ids = $this->createRangeId($params["multi_select"]);
                $querySelectPicture = "SELECT `id`, `avatar` AS `name` FROM `user` WHERE `id` IN ($ids)";
                $array_picture = $this->fetchPairs($querySelectPicture);

                foreach($array_picture as $key => $value){
                    $upload->removeFile("user", $value);
                }

                $query      = $this->createDeleteSql($params["multi_select"], "`cart`", array("condition" => "id_user"));
                $this->executeAndReturnAffectedRows($query);
                $query      = $this->createDeleteSql($params["multi_select"], "`user`", array("condition" => "id"));
                return $this->executeAndReturnAffectedRows($query);
            }
        }


        //Ajax change status
        public function ajaxChangeStatus($params){
            $statusUpdate  = $params["valueUpdateTo"];
            $elementUpdate = $params["elementUpdateStatus"];
            $query         = "UPDATE `user` SET $elementUpdate = '$statusUpdate' WHERE id = $params[id_update]";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $link          = ($statusUpdate == 1)? Helper::createPublicLinkA(array("element" => $elementUpdate, "id" => $params["id_update"], "controller" => "user")) : Helper::createUnpublicLinkA(array("element" => $elementUpdate, "id" =>  $params["id_update"], "controller" => "user"));
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
            $query         = "UPDATE `user` SET ordering = '$orderingUpdate' WHERE id = $params[id_update]";
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
                $query      = "UPDATE `user` SET `status` = 1 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }
        
        //MULTI UN PUBLIC
        public function multiUnpublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `user` SET `status` = 0 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }

    }
    