<?php
    class CartBookModel extends Model{

        //To pagination
        public function countItem(){
            if( isset($_SESSION["userLogin"]["cart"]) ){
                return count($_SESSION["userLogin"]["cart"]);
            }else{
                return false;
            }
        }

        //COUNT IN HISTORY
        public function countItemHistory(){
            $query = "SELECT COUNT(`id`) FROM `cart` WHERE `date` > 0";

            $result     = $this->fetchRow($query);
            return $result;
        }


        
        public function getInfo($params){
            $idBook     = $params["id"];
            $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name`, c.`id` AS `category_id` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` = $idBook";
            $query[]		= "AND b.`status` = 1";
            $query      = implode(" ", $query);

            $result     = $this->fetchRow($query);
            return $result;
        }

        public function listItem($params){
            if( isset($_SESSION["userLogin"]["cart"]) && !empty(@$_SESSION["userLogin"]["cart"]) ){
                $ids = "";
                foreach($_SESSION["userLogin"]["cart"] as $key => $value){
                    $ids .= ", '$key'";
                }
                $ids = substr($ids, 2);
                $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
                $query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
                $query[] 		= "ON b.`category_id` = c.`id`";
                $query[]		= "WHERE b.`id` IN ($ids)";


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
        }

        public function listItemHistory($params){
            $query[] 		= "SELECT id, books, prices, quantities, names, pictures, `status`, `date`";
            $query[] 		= "FROM `cart`";
            $query[]		= "WHERE `date` > 0";
            $query[]		= "AND `id_user` = " . $_SESSION["userLogin"]["infoUser"]["id"];
            $query[]		= "ORDER BY `date` DESC";

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

        public function listSpecial($params){

            $query[] 		= "SELECT b.`id`, b.`views`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` > 0";
            $query[]		= "AND b.`special` = 1";
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
            $query[]		= "WHERE`status` = 1";
            $query = implode(" ", $query);
            return $this->fetchAll($query);
        }

        //AJAX RELATED BOOK
        public function relatedBook($params){
            $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`category_id` = $params[category_id]";
            $query[]		= "AND b.`status` = 1";
            $query[]		= "AND c.`status` = 1";
            $query[]		= "AND b.`id` != $params[id]";
            $query[]		= "LIMIT 0, 4";
            $query  = implode(" ", $query);
            $result = $this->fetchAll($query);
            foreach($result as $key => $value){
                $result[$key]["picture"]    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);
                $result[$key]["href"]       = URL::createURL("client", "index", "detail", array("id" => $value["id"]), "detail-book-$value[id]");
                $result[$key]["price"]      = number_format($value["price"]);
                $result[$key]["sale_off"]   = ($value["sale_off"] != 0) ? '<span class="ribbon">-'.$value["sale_off"].'%</span>' : "";
            }
            echo json_encode($result);

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

        public function ajaxSearch($params){
            $query  = "SELECT id, `name`, `picture`, `book_descript` FROM `book` WHERE `status` = 1 AND `name` LIKE '%$params[keyword]%'";
            $result = $this->fetchAll($query);
            if(!empty($result)){
                foreach($result as $key => $value){
                    $result[$key]["picture"]    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);
                    $result[$key]["href"]       = URL::createURL("client", "index", "detail", array("id" => $value["id"]), "/detail-book-$value[id].html");
                    $result[$key]["book_descript"]   = Helper::sliceStr($result[$key]["book_descript"], 10);
                }
            }
            echo json_encode($result);
        }
    }