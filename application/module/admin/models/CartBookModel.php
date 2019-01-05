<?php
    class CartBookModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
        }

        //To pagination
        public function countItem($params){

            $query[] 		= "SELECT COUNT(`id`) AS 'totalItem'";
			$query[] 		= "FROM `cart`";
            $query[]		= "WHERE `date` > 0";

            //TYPING SEARCH
            // if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
            //     if($params["filter_typing"] == "all"){
            //         $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `group_descript` LIKE '%".$params["content_search"]."%' ";
            //     }else{
            //         $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
            //     }
            // }

            //SELECT SEARCH
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
			$query[] 		= "FROM `cart`";
            $query[]		= "WHERE `date` > 0";

            // TYPING SEARCH
            // if(isset($params["filter_typing"]) && $params["filter_typing"] != ""){
            //     if($params["filter_typing"] == "all"){
            //         $query[] = "AND `name` LIKE '%".$params["content_search"]."%' OR `book_descript` LIKE '%".$params["content_search"]."%' ";
            //     }else{
            //         $query[] = "AND `$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
            //     }
            // }

            if(isset($params["select_filter_status"])){
                if($params["select_filter_status"] != "default"){
                    $query[] = "AND `status` = '$params[select_filter_status]'";
                }
            }

            //FILTER
            if(isset($params["filter_column"])){
                $query[]    = "ORDER BY " . $params["filter_column"] . " " . $params["filter_column_dir"];
            }else{
                $query[]    = "ORDER BY `date` DESC";
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
            $query = "SELECT * FROM `cart` WHERE id = $params[id]";
            return $this->fetchRow($query);
        }

        //MULTI PUBLIC
        public function multiPublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `cart` SET `status` = 1 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }
        
        //MULTI UN PUBLIC
        public function multiUnpublic($params){
            if(!empty($params["multi_select"])){
                $xid   = $this->createRangeId($params["multi_select"]);
                $query      = "UPDATE `cart` SET `status` = 0 WHERE id IN ($xid)";
                return $this->executeAndReturnAffectedRows($query);
            }
        }

        //Ajax change status
        public function ajaxChangeStatus($params){
            $statusUpdate  = $params["valueUpdateTo"];
            $elementUpdate = $params["elementUpdateStatus"];
            $query         = "UPDATE `cart` SET $elementUpdate = '$statusUpdate' WHERE id = '$params[id_update]'";
            $affectedRows  = $this->executeAndReturnAffectedRows($query);
            $link          = ($statusUpdate == 1)? Helper::createPublicLinkA(array("element" => $elementUpdate, "id" => $params["id_update"], "controller" => "cart-book")) : Helper::createUnpublicLinkA(array("element" => $elementUpdate, "id" =>  $params["id_update"], "controller" => "cart-book"));
            $arrayReturn   = array(
                                    "affectedRows"  => $affectedRows,
                                    "elementUpdate" => $elementUpdate,
                                    "statusUpdate"  => $statusUpdate,
                                    "idUpdate"      => $params["id_update"],
                                    "link"          => $link
                                );
            echo json_encode( $arrayReturn );
        }

    }
    