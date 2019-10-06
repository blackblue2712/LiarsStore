<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;    
    class IndexModel extends Model{

        //To pagination
        public function countItem($params){
            $query[] 		= "SELECT COUNT(`b`.`id`) AS 'totalItem'";
			$query[] 		= "FROM `book` AS `b`, `category` AS `c`";
            $query[]		= "WHERE b.`category_id` = `c`.`id`";
            $query[]		= "AND b.`status` = 1";
            $query[] 		= "AND `c`.`status` = 1";

            //SEARCH CATEGORY
            if(isset($params["category_id"])){
                $query[]		= "AND `category_id` = $params[category_id]";
            }

            //SEARCH MULTI CATEGORY
            if(isset($params["form"]["search_category"])){
                $ids = $this->createRangeId($params["form"]["search_category"]);
                $query[]		= "AND `category_id` IN ($ids)";
            }

            // TYPING SEARCH
            if(isset($params["form"]["keyword"]) && $params["form"]["keyword"] != ""){
                // if($params["filter_typing"] == "all"){
                //     $query[] = "AND b.`name` LIKE '%".$params["content_search"]."%' OR `book_descript` LIKE '%".$params["content_search"]."%' ";
                // }else{
                //     $query[] = "AND b.`$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                // }
                $query[] = "AND b.`name` LIKE '%".$params["form"]["keyword"]."%' ";
            }

            $query = implode(" ", $query);
            return $this->fetchRow($query);
        }
        
        public function getInfo($params){
            $idBook         = $params["id"];
            $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name`, c.`id` AS `category_id` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` = $idBook";
            $query[]		= "AND b.`status` = 1";
            $query          = implode(" ", $query);
            $result         = $this->fetchRow($query);
            return $result;
        }
        public function getChapter($params){
            $idBook         = $params["id"];
            $query[] 		= "SELECT cb.`id`, cb.`content_chapter`, cb.`status`, cb.`ordering`, cb.`chapter_number`";
			$query[] 		= "FROM `book_chapter` AS cb LEFT JOIN `book` AS b";
			$query[] 		= "ON cb.`book_id` = b.`id`";
            $query[]		= "WHERE b.`id` = $idBook";
            $query[]		= "AND b.`status` = 1";
            $query[]		= "ORDER BY cb.`chapter_number` ASC";
            $query          = implode(" ", $query);
            $result         = $this->fetchAll($query);
            return $result;
        }

        public function getInfoUserLogin($params){
            $username   = $params["username"];
            $query[] 	= "SELECT `u`.`id`, `u`.`username`,`u`.`avatar`, `u`.`fullname`, `u`.`email`, `u`.`status`, `g`.`group_acp`, `g`.`name`";
            $query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
            $query[] 	= "WHERE `u`.`username` = '$username'";
            $query      = implode(" ", $query);

            $result     = $this->fetchRow($query);
            return $result;
        }

        public function listItem($params){

            $query[] 		= "SELECT b.`id`, b.`views`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, b.`status`, b.`ordering`, b.`created`, b.`created_by`, b.`modified`, b.`modified_by`, b.`book_descript`, c.`name` AS `category_name` ";
			$query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
			$query[] 		= "ON b.`category_id` = c.`id`";
            $query[]		= "WHERE b.`id` > 0";
            $query[]		= "AND b.`status` = 1";
            $query[] 		= "AND `c`.`status` = 1";

            //SEARCH CATEGORY
            if(isset($params["category_id"])){
                $query[]		= "AND b.`category_id` = $params[category_id]";
            }
            //SEARCH MULTI CATEGORY
            if(isset($params["form"]["search_category"])){
                $ids = $this->createRangeId($params["form"]["search_category"]);
                $query[]		= "AND b.`category_id` IN ($ids)";
            }
             // TYPING SEARCH
             if(isset($params["form"]["keyword"]) && $params["form"]["keyword"] != ""){
                // if($params["filter_typing"] == "all"){
                //     $query[] = "AND b.`name` LIKE '%".$params["content_search"]."%' OR `book_descript` LIKE '%".$params["content_search"]."%' ";
                // }else{
                //     $query[] = "AND b.`$params[filter_typing]` LIKE '%".$params["content_search"]."%' ";
                // }
                $query[] = "AND b.`name` LIKE '%".$params["form"]["keyword"]."%' ";
            }

            $query[]		= "ORDER BY `id` DESC";
            

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
            // $query[]		= "WHERE b.`special` = 1";
            $query[]		= "WHERE b.`status` = 1";
            $query[] 		= "AND `c`.`status` = 1";


            $query[]		= "ORDER BY `views` DESC";
            $query[]		= "LIMIT 0, 8";
            $query = implode(" ", $query);

            return $this->fetchAll($query);

        }

        public function randomItem(){
            if( file_get_contents( PATH_FILES . DS . "xml/timeRandomSilde.txt" ) + 3600 < time()){
                file_put_contents( PATH_FILES . DS . "xml/timeRandomSilde.txt", time());
                
                $queryId[] 		= "SELECT b.`id`";
                $queryId[] 		= "FROM `book` AS b";
                $ids            = $this->fetchID(implode(" ", $queryId));
                $ids            = $ids["id"];
                shuffle($ids);
                $ids            = $this->createRangeId($ids, array("limit" => 10));

                $query[] 		= "SELECT b.`id`, b.`name`, b.`price`,b.`special`,b.`sale_off`,b.`picture`, c.`name` AS `category_name` ";
                $query[] 		= "FROM `book` AS b LEFT JOIN `category` AS c";
                $query[] 		= "ON b.`category_id` = c.`id`";
                $query[]		= "WHERE b.`id` IN ($ids)";
                $query[]		= "AND b.`status` = 1";
                $query[] 		= "AND `c`.`status` = 1";

                $query  = implode(" ", $query);
                $result = $this->fetchAll($query);
                shuffle($result);
                XML::createXMLPublic($result, "book_random", 'book');
                return XML::readFileXML("book_random");
            }else{
                return XML::readFileXML("book_random");
            }
        }

        //SELECT MIN MAX EPISODE
        public function minMaxEp($params){
            $id_book    = $params["id_book"];
            $query = "SELECT MIN(chapter_number) AS minEp, MAX(chapter_number) AS maxEp FROM book_chapter WHERE book_id = $id_book";
            return $this->fetchRow($query);
        }

        public function listCategory($params){
            $query[] 		= "SELECT `id`, `name`";
			$query[] 		= "FROM `category`";
            $query[]		= "WHERE `id` > 0";
            $query[]		= "AND `status` = 1";
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
                $result[$key]["href"]       = URL::createURL("client", "index", "detail", array("id" => $value["id"]), "/detail-book-$value[id]");
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
                    $result[$key]["href"]       = URL::createURL("client", "index", "detail", array("id" => $value["id"]));
                    $result[$key]["book_descript"]   = Helper::sliceStr($result[$key]["book_descript"], 10);
                }
            }
            echo json_encode($result);
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

        //Insert user Register
        public function insertUser($params){
            if(!empty($params)){
                $params["created"]      = date("Y-m-d H:i:s", time());
                $params["created_by"]   = "Client";
                $params["register_ip"]  = $_SERVER["SERVER_ADDR"];
                $params["username"]     = mysqli_escape_string($this->_connect, $params["username"]);
                $params["email"]        = mysqli_escape_string($this->_connect, $params["email"]);
                $passwordNotMd5         = $params["password"];
                $params["password"]     = md5($params["password"]);
                $params["group_id"]     = 23;
                $params["active_code"]  = Helper::createRandomCharacter(20);

                $url_active_code        = "http://localhost" . URL::createURL("client", "index", "activeCode", array("code" => $params["active_code"]));
                // $url_active_code        = "http://i2k.info" . URL::createURL("client", "index", "activeCode", array("code" => $params["active_code"]));
                //SEND MAIL
                require PATH_LIBS . DS . 'extends/Mailer/autoload.php';
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    // $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
                    $mail->Host     = 'smtp.gmail.com';                   // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = EMAIL_SENT;                         // SMTP username
                    $mail->Password = PASSWORD;                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('nghiab1706729@student.ctu.edu.vn', 'Dang huu nghia'); 
                    $mail->addAddress($params["email"], "Nhu hao");                    // Add a recipient

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Actice your account';
                    $mail->Body    = '<center><h3><b>Wellcome to LiarsStore<b></h3></center>
                                      <p><b>Here is infomation about your account:</b></p>
                                      <p>Username: '.$params["username"].'</p>
                                      <p>Password: '.$passwordNotMd5.'</p>
                                      <p>Code active: '.$params["active_code"].'</p>
                                        Click <a href="'.$url_active_code.'">here</a> to active your account <a href="'.$url_active_code.'">' .$url_active_code. '</a>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                    echo "<script>alert(1)</script>";
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
                $query                  = $this->createInsertSql($params, "`user`");
                return $countRowAffected= $this->insertSql($query);
            }
        }

        public function ajaxResendActiveCode($params){
            if(isset($_SESSION["emailToResendActivecCode"])){
                $params["active_code"]  = Helper::createRandomCharacter(20);
                $url_active_code        = "http://localhost" . URL::createURL("client", "index", "activeCode", array("code" => $params["active_code"]));
                // $url_active_code        = "http://i2k.info" . URL::createURL("client", "index", "activeCode", array("code" => $params["active_code"]));

                //SEND MAIL
                require PATH_LIBS . DS . 'extends/Mailer/autoload.php';
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    // $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
                    $mail->Host     = 'smtp.gmail.com';                   // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = EMAIL_SENT;                        // SMTP username
                    $mail->Password = PASSWORD;                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('nghiab1706729@student.ctu.edu.vn', 'Dang huu nghia'); 
                    $mail->addAddress($params["email"], "Nhu hao");

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Actice your account';
                    $mail->Body    = '<center><h3><b>Wellcome to LiarsStore<b></h3></center>
                                      <p><b>Here is new code active: </b>'.$params["active_code"].'</p>
                                      <p>You can <b>only</b> use the new code</p>
                                        Click <a href="'.$url_active_code.'">here</a> to active your account <a href="'.$url_active_code.'">' .$url_active_code. '</a>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    // echo 'Message has been sent';
                    alert(12)
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
                $query                  = "UPDATE `user` SET `active_code` = '$params[active_code]' WHERE `email` = '$_SESSION[emailToResendActivecCode]'";
                $countRowAffected= $this->executeAndReturnAffectedRows($query);
            }
        }

        //RENDER CHAPTER
        public function renderChapter($params){
            $id_book    = $params["id_book"];
            $chapter    = $params["chapter"];
            $query      = "SELECT `content_chapter` FROM `book_chapter` WHERE `book_id` = '$id_book' AND `chapter_number` = '$chapter'";
            return $this->fetchRow($query);
        }
    }