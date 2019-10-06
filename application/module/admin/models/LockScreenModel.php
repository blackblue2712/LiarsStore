<?php
    class LockScreenModel extends Model{

        public function ajaxCheckPassword(){
            $username = $_SESSION["userLogin"]["infoUser"]["username"];
            @$password = md5($_POST["password"]);
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