<?php
    class CategoryModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        //To pagination
        public function countItem($params){

            $query[] 		= "SELECT COUNT(`id`) AS 'totalItem'";
			$query[] 		= "FROM `category`";
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
            if(isset($params["select_filter_category"])){
                if($params["select_filter_category"] != "default"){
                    $query[] = "AND `id` = '$params[select_filter_category]'";
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

            $query[] 		= "SELECT * ";
			$query[] 		= "FROM `category`";
            $query[]		= "WHERE `id` > 0";

            // TYPING SEARCH
            if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
                if($params["filter_typing"] == "all"){
                    $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `category_descript` LIKE '%".$params["content_search"]."%' ";
                }else{
                    $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                }
            }

            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND `status` = '$params[select_filter_status]'";
                }
            }
            if(isset($params["select_filter_category"])){
                if($params["select_filter_category"] != "default"){
                    $query[] = "AND `id` = '$params[select_filter_category]'";
                }
            }

            //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }else{
                $query[]    = "ORDER BY `id` ASC";
            }

            //PAGINATION
			$pagination 		= @$params["pagination"];
			$totalItemPerPage 	= $pagination["totalItemPerPage"];
			if($totalItemPerPage > 0){
				$position	= ($params["pagination"]["currentPage"]-1)*$totalItemPerPage;
				$query[]	= "LIMIT $position, $totalItemPerPage";
			}

            $query = implode(" ", $query);

            return $this->fetchAll($query);

        }

        public function listCategory($params){
            $query[] 		= "SELECT `id`, `name`, `picture`";
			$query[] 		= "FROM `category`";
            $query[]		= "WHERE `status` = 1";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        public function infoItem($params){
            $query = "SELECT * FROM `category` WHERE id = $params[id]";
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

        //Add new category
        public function insertCategory($params){
            if(!empty($params)){
                $params["created"]          = date("Y-m-d H:i:s", time());
                $params["created_by"]       = $this->_userInfoInSession["username"];
                $params["name"]             = mysqli_escape_string($this->_connect, $params["name"]);
                $params["category_descript"]= mysqli_escape_string($this->_connect, $params["category_descript"]);
                $params["picture"]          = mysqli_escape_string($this->_connect, $params["picture"]);

                $query                  = $this->createInsertSql($params, "`category`");
                return $countRowAffected= $this->insertSql($query);
            }
        }

        //Update category
        public function updateCategory($params){
            if(!empty($params)){
                if(isset($params["form"]["picture"])){
                    include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                    $upload             = new Upload();
                    $querySelectPicture = "SELECT `id`, `picture` AS `name` FROM `category` WHERE `id` IN ($params[id])";
                    $picture            = $this->fetchRow($querySelectPicture);
                    $upload->removeFile("category", $picture["name"]);
                }
                $params["modified"]      = date("Y-m-d H:i:s", time());
                $params["modified_by"]   = $this->_userInfoInSession["username"];
                $query                   = $this->createUpdateSql($params, "`category`");
                return $countRowAffected = $this->insertSql($query);
            }
        }

        //Delete multi category
        public function deleteMulti($params){
            include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
            $upload         = new Upload();

            if(!empty($params["multi_select"])){
                $ids = $this->createRangeId($params["multi_select"]);
                $querySelectPicture = "SELECT `id`, `picture` AS `name` FROM `category` WHERE `id` IN ($ids)";
                $array_picture = $this->fetchPairs($querySelectPicture);

                foreach($array_picture as $key => $value){
                    $upload->removeFile("category", $value);
                }

                $query      = $this->createDeleteSql($params["multi_select"], "`category`", array("condition" => "id"));
                return $this->executeAndReturnAffectedRows($query);
            }
        }


        //Ajax change status
        public function ajaxChangeStatus($params){
            $statusUpdate  = $params["valueUpdateTo"];
            $elementUpdate = $params["elementUpdateStatus"];
            $query         = "UPDATE `category` SET $elementUpdate = '$statusUpdate' WHERE id = $params[id_update]";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $link          = ($statusUpdate == 1)? Helper::createPublicLinkA(array("element" => $elementUpdate, "id" => $params["id_update"], "controller" => "category")) : Helper::createUnpublicLinkA(array("element" => $elementUpdate, "id" =>  $params["id_update"], "controller" => "category"));
            $arrayReturn   = array(
                                    "affectedRows"  => $affectedRows,
                                    "elementUpdate" => $elementUpdate,
                                    "statusUpdate"  => $statusUpdate,
                                    "idUpdate"      => $params["id_update"],
                                    "link"          => $link,
                                );
            echo json_encode( $arrayReturn );
        }

        //Ajax Change Ordering
        public function ajaxChangeOrdering($params){
            $orderingUpdate= $params["valueUpdateTo"];
            $query         = "UPDATE `category` SET ordering = '$orderingUpdate' WHERE id = $params[id_update]";
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
                $query      = "UPDATE `category` SET `status` = 1 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }
        
        //MULTI UN PUBLIC
        public function multiUnpublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `category` SET `status` = 0 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }

    }
    