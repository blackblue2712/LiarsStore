<?php
    class BookModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        //To pagination
        public function countItem($params){

            $query[] 		= "SELECT COUNT(`id`) AS 'totalItem'";
			$query[] 		= "FROM `book`";
            $query[]		= "WHERE `id` > 0";

            //TYPING SEARCH
            // if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
            //     if($params["filter_typing"] == "all"){
            //         $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `group_descript` LIKE '%".$params["content_search"]."%' ";
            //     }else{
            //         $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
            //     }
            // }

            //SELECT SEARCH
            if(isset($params["select_filter_special"])){
                if($params["select_filter_special"] != "default"){
                    $query[] = "AND `special` = '$params[select_filter_special]'";
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

            $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` > 0";

            // TYPING SEARCH
            if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
                if($params["filter_typing"] == "all"){
                    $query[] = "AND b.`name` LIKE '%".$params["content_search"]."%' OR `book_descript` LIKE '%".$params["content_search"]."%' ";
                }else{
                    $query[] = "AND b.`$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                }
            }

            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND b.`status` = '$params[select_filter_status]'";
                }
            }
            if(isset($params["select_filter_special"])){
                if($params["select_filter_special"] != "default"){
                    $query[] = "AND b.`special` = '$params[select_filter_special]'";
                }
            }

            //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }else{
                $query[]    = "ORDER BY b.`id` ASC";
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

        public function listCategory($params){
            $query[] 		= "SELECT `id`, `name`";
			$query[] 		= "FROM `category`";
            $query[]		= "WHERE `id` > 0";
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
            $query = "SELECT * FROM `book` WHERE id = $params[id]";
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

        //Add new book
        public function insertBook($params){
            if(!empty($params)){
                $params["created"]      = date("Y-m-d H:i:s", time());
                $params["created_by"]   = $this->_userInfoInSession["username"];
                $params["name"]         = addslashes(mysqli_escape_string($this->_connect, $params["name"]));
                $params["book_descript"]= addslashes(mysqli_escape_string($this->_connect, $params["book_descript"]));
                $params["category_id"]  = mysqli_escape_string($this->_connect, $params["category_id"]);

                $query                  = $this->createInsertSql($params, "`book`");
                return $countRowAffected= $this->insertSql($query);
            }
        }

        //Update book
        public function updateBook($params){
            if(!empty($params)){
                if(isset($params["form"]["picture"])){
                    include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                    $upload             = new Upload();
                    $querySelectPicture = "SELECT `id`, `picture` AS `name` FROM `book` WHERE `id` IN ($params[id])";
                    $picture            = $this->fetchRow($querySelectPicture);
                    $upload->removeFile("book", $picture["name"], 98, 150);
                }
                $params["form"]["modified"]      = date("Y-m-d H:i:s", time());
                $params["form"]["modified_by"]   = $this->_userInfoInSession["username"];
                $params["form"]["name"]          = addslashes(mysqli_escape_string($this->_connect, $params["form"]["name"]));
                $params["form"]["book_descript"] = addslashes(mysqli_escape_string($this->_connect, $params["form"]["book_descript"]));
                $query                           = $this->createUpdateSql($params, "`book`");
                return $countRowAffected         = $this->insertSql($query);
            }
        }

        //Delete multi user
        public function deleteMulti($params){
            include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
            $upload         = new Upload();
            if(!empty($params["multi_select"])){
                $ids = $this->createRangeId($params["multi_select"]);
                $querySelectPicture = "SELECT `id`, `picture` AS `name` FROM `book` WHERE `id` IN ($ids)";
                $array_picture = $this->fetchPairs($querySelectPicture);

                foreach($array_picture as $key => $value){
                    $upload->removeFile("book", $value);
                }

                $query      = $this->createDeleteSql($params["multi_select"], "`user`", array("condition" => "id"));
                return $this->executeAndReturnAffectedRows($query);
            }
        }


        //Ajax change status
        public function ajaxChangeStatus($params){
            $statusUpdate  = $params["valueUpdateTo"];
            $elementUpdate = $params["elementUpdateStatus"];
            $query         = "UPDATE `book` SET $elementUpdate = '$statusUpdate' WHERE id = $params[id_update]";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $link          = ($statusUpdate == 1)? Helper::createPublicLinkA(array("element" => $elementUpdate, "id" => $params["id_update"], "controller" => "book")) : Helper::createUnpublicLinkA(array("element" => $elementUpdate, "id" =>  $params["id_update"], "controller" => "book"));
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
            $query         = "UPDATE `book` SET ordering = '$orderingUpdate' WHERE id = $params[id_update]";
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
                $query      = "UPDATE `book` SET `status` = 1 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }
        
        //MULTI UN PUBLIC
        public function multiUnpublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `book` SET `status` = 0 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }

    }
    