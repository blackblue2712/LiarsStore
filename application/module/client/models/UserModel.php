<?php
    class UserModel extends Model{
        private $_userInfoInSession;
        public function __construct(){
            parent::__construct();
            $this->_userInfoInSession = @$_SESSION["userLogin"]["infoUser"];
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


        public function listSpecial($params){

            $query[] 		= "SELECT b.`id`, b.`views`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`special` = 1";
            $query[]		= "AND b.`status` = 1";
            $query[]		= "AND c.`status` = 1";


            $query[]		= "ORDER BY `id` DESC";
            $query[]		= "LIMIT 0, 8";
            $query = implode(" ", $query);

            return $this->fetchAll($query);

        }

        public function randomItem(){
            $queryId[] 		= "SELECT b.`id`";
            $queryId[] 		= "FROM `book` AS b";
            $ids            = $this->fetchID(implode(" ", $queryId));
            $ids            = $ids["id"];
            shuffle($ids);
            $ids            = $this->createRangeId($ids, array("limit" => 10));

            $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` IN ($ids)";
            $query[]		= "AND b.`status` = 1";
            $query[]		= "AND c.`status` = 1";

            $query  = implode(" ", $query);
            $result = $this->fetchAll($query);
            shuffle($result);
            return $result;
        }

        public function listCategory($params){
            $query[] 		= "SELECT `id`, `name`";
			$query[] 		= "FROM `category`";
            $query[]		= "WHERE `id` > 0";
            $query[]		= "AND `status` = 1";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        //Ajax chagne Info
        public function changeInfo($params){
            $idChange = $_SESSION["userLogin"]["infoUser"]["id"];
            $query = "UPDATE `user` SET `$params[columnChange]` = '$params[valueChange]' WHERE id = '$idChange'";
            $affectedRow = $this->executeAndReturnAffectedRows($query);

            if($affectedRow > 0){
                $_SESSION["userLogin"]["infoUser"][$params["columnChange"]] = $params["valueChange"];
                echo json_encode( array("status" => "1") );
            }else{
                echo json_encode( array("status" => "0") );
            }
        } 
        //Ajax chagne Password
        public function changePassword($params){
            $idChange     = $_SESSION["userLogin"]["infoUser"]["id"];
            $query        = "SELECT `password` FROM `user`  WHERE id = '$idChange'";
            $passwordUser = $this->fetchRow($query)["password"];

            if($passwordUser == md5($params["oldPassword"])){
                $newPassword = md5($params["newPassword"]);
                $queryUpdate = "UPDATE `user` SET `password` = '$newPassword' WHERE id = '$idChange'";
                $this->executeAndReturnAffectedRows($queryUpdate);
                echo json_encode( array("status" => 1) );
            }else{
                // $_SESSION["error"] = "error";
                echo json_encode( array("status" => 0) );
            }
        }

        //Update user
        public function changeAvatar($avatar){
            $idUser = $_SESSION["userLogin"]["infoUser"]["id"];
            include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
            $upload             = new Upload();
            $querySelectPicture = "SELECT `id`, `avatar` AS `name` FROM `user` WHERE `id` = '$idUser'";
            $picture            = $this->fetchRow($querySelectPicture);
            $upload->removeFile("user", $picture["name"], 98, 150);

            $query = "UPDATE `user` SET `avatar` = '$avatar' WHERE `id` = '$idUser'";
            return $countRowAffected = $this->executeAndReturnAffectedRows($query);
        }
    }
    