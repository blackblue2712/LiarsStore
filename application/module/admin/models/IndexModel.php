<?php
    class IndexModel extends Model{
        public function getInfo($params){
            $username   = $params["form"]["username"];
            $query[] 	= "SELECT `u`.`id`, `u`.`username`, `u`.`avatar`, `u`.`fullname`, `u`.`email`, `g`.`group_acp`, `g`.`name`";
            $query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
            $query[] 	= "WHERE `u`.`username` = '$username'";
            $query      = implode(" ", $query);

            $result     = $this->fetchRow($query);
            return $result;
        }

        public function ajaxCheckPassword(){
            $username = $_SESSION["userLogin"]["infoUser"]["username"];
            $password = md5($_POST["password"]);
            $query    = "SELECT `id` FROM `user` WHERE `password` = '$password' AND `username` = '$username' ";
            $isExists = $this->isExists($query);

            $response = array(
                                "status" => $isExists,
                        );
            if($isExists == true){
                $response["redirect"] = URL::createURL("admin", "index", "index");
            }
            echo json_encode( $response );
            return $isExists;
        }
    }