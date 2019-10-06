<?php
    class IndexController extends Controller{
        public function __construct($params){
            parent::__construct($params);
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("client/main");
            $this->_templateObj->load();
            
            include_once PATH_EXTENDS . DS . "XML/" . "XML.php";
            $this->_view->_listCategory = XML::readFileXML("category");

            //List special
            $listSpecial = $this->_model->listSpecial($this->_params);
            $this->_view->listSpecial = $listSpecial;

            //List random
            $listRandom = $this->_model->randomItem($this->_params);
            $this->_view->listRandom = $listRandom;
        }
        
        public function indexAction(){
            //Paging
            $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            $this->setPagination(array("totalItemPerPage" => 12, "pageRange" => 3));
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List book
            $listBook = $this->_model->listItem($this->_params);
            $this->_view->listBook = $listBook;

            $this->_view->render("index/index", true);
        }

        //DETAI BOOK
        public function detailAction(){
            if(isset($this->_params['id'])){
                $this->_view->detailBook = $this->_model->getInfo($this->_params);
                $this->_view->chapterBook = $this->_model->getChapter($this->_params);
            }

            $this->_view->render("index/detail", true);
        }

        //AJAX SEARCH
        public function ajaxSearchAction(){
            $this->_model->ajaxSearch($this->_params);
        }

        //AJAX RELATED BOOK
        public function relatedAction(){
            $this->_model->relatedBook($this->_params);
        } 

        public function loginAction(){

            $this->_templateObj->setFileConfig("loginTemplate.ini");
            $this->_templateObj->setFileTemplate("login.php");
            $this->_templateObj->setFolderTemplate("client/main");
            $this->_templateObj->load();

            if(isset($_SESSION["userLogin"]) && $_SESSION["userLogin"]["isLogin"] == 1){
                URL::redirect("client", "index", "index", null, "/index.html");
            }

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["form"]["token"], "client", "index", "login");                
            }

            if(isset($_SESSION["token"])){
                $validate = new Validate($this->_params["form"]);

                $username = $this->_params["form"]["username"];
                $password = md5($this->_params["form"]["password"]);

                $query = "SELECT * FROM user WHERE username = '$username' AND `password` = '$password' LIMIT 1";

                $validate->addRule("username", "existsRecord", array("model" => $this->_model, "query" => $query));
                $validate->run();
               if( $validate->isValid() ){
                    $infoUser        = $this->_model->getInfoUserLogin($this->_params["form"]);
                    $isActive        = $infoUser["status"];
                    if($isActive == 0){
                        Session::delete("token");
                        Session::set("emailToResendActivecCode", $infoUser["email"]);
                        URL::redirect("client", "index", "activeAccount", null, "/activeAccount.html");
                    }else{
                        $array_session   = array(
                            "infoUser"   => $infoUser,
                            "isLogin"    => true,
                            "timeLogin"  => time() 
                        );
                        Session::set("userLogin", $array_session);
                        URL::redirect("client", "index", "index", null, "/index.html");
                    }
               }else{
                   Session::set("msg", "Username or password was wrong");
               }
            }

            $this->_view->render("index/login");

        }

        //Ajax login
        public function ajaxLoginAction(){

            Session::set("token", $this->_params["token"]);

            if(isset($_SESSION["token"])){
                $validate = new Validate($this->_params);

                $username = $this->_params["username"];
                $password = md5($this->_params["password"]);

                $query = "SELECT * FROM user WHERE username = '$username' AND `password` = '$password' LIMIT 1";

                $validate->addRule("username", "existsRecord", array("model" => $this->_model, "query" => $query));
                $validate->run();
               if( $validate->isValid() ){
                    $infoUser        = $this->_model->getInfoUserLogin($this->_params);
                    $isActive        = $infoUser["status"];
                    if($isActive == 0){
                        Session::delete("token");
                        Session::set("emailToResendActivecCode", $infoUser["email"]);
                        echo json_encode( array("redirect" => URL::createURL("client", "index", "activeAccount", null, "/active-account.html")) );
                    }else{
                        $array_session   = array(
                            "infoUser"   => $infoUser,
                            "isLogin"    => true,
                            "timeLogin"  => time() 
                        );
                        Session::set("userLogin", $array_session);
                        echo json_encode($array_session);    
                    }
                    
               }else{
                    echo json_encode( array("error" => "Username or Password was wrong") );
               }
            }

        }

        //Log out
        public function logoutAction(){
            Session::delete("userLogin");
            Session::delete("token");
            Session::delete("access_token");
            $urlRedirect = URL::createURL("client", "index", "index", null, "/index.html");

            echo json_encode( array("redirect" => $urlRedirect) );
        }

        public function ajaxCheckFormAction(){
            $this->_model->ajaxCheckForm($this->_params);
        }

        //REGSITER
        public function registerAction(){
            $form_user   = $this->_params["form"];
            $validate    = new Validate($form_user);
            
            $queryN = "SELECT * FROM `user` WHERE username = '" . $form_user["username"] . "'";
            $queryE = "SELECT * FROM `user` WHERE email = '" . $form_user["email"] . "'";
            if(isset($this->_params["id"])){
                $queryN .= " AND id != '" . $this->_params["id"] . "'";
                $queryE .= " AND id != '" . $this->_params["id"] . "'";
            }

            $validate->addRule("username", "string-existsRecord", array("model" => $this->_model, "query" => $queryN, "min" => "2", "max" => "10"))
                        ->addRule("email", "email-existsRecord", array("model" => $this->_model, "query" => $queryE));
            $validate->run();
            
            if($validate->isValid()){
                $affectedRows = $this->_model->insertUser($this->_params["form"]);
                $_SESSION["emailToResendActivecCode"] = $this->_params["form"]["email"];
                URL::redirect("client", "index", "activeAccount", null, "/activeAccount.html");
            }else{
                echo '<pre style=color:#176F08;font-weight:bold >';
                print_r($validate->getErrors());
                echo '</pre>';
            }
            $this->_view->validItem = $validate->getValidItem(); 
        }

        //ACTIVE CODE
        public function activeCodeAction(){
            if(isset($this->_params["code"])){
                $active_code = $this->_params["code"];
                $query = "UPDATE `user` SET `status` = 1, `active_code` = '' WHERE `active_code` = '$active_code'";
                $affectedRow = $this->_model->executeAndReturnAffectedRows($query);
                if($affectedRow > 0){
                    Session::delete("emailToResendActivecCode");
                    Session::set("notice", "Your account has been activated");
                }else{
                    Session::set("notice", "Your active code has been expired");
                }
                URL::redirect("client", "index", "login", null, "/login.html");
            }
        }

        //ACTIVE ACCOUNT  IF NOT ACTIVE CODE
        public function activeAccountAction(){
            $this->_view->render("index/activeAccount");
        }
        public function resendActiveCodeAction(){
            $this->_model->ajaxResendActiveCode($this->_params);
            // URL::redirect("client", "idnex");
        }

        //Error
        public function errorAction(){
            $this->_view->render("error/index");
        }

        //Readbook
        public function readBookAction(){
            $this->_templateObj->setFileTemplate("read.php");
            $this->_templateObj->load();
            $this->_view->renderedChapter = $this->_model->renderChapter($this->_params);
            $this->_view->minMaxEp = $this->_model->minMaxEp($this->_params);
            // $this->countViewAction($this->_params["id_book"]);
            $this->_view->render("index/readBook");
        }

        //Count Views
        public function countViewAction(){
            $book_id = isset($this->_params["idBook"]) ? (int)$this->_params["idBook"] : 0;
            $query = "UPDATE `book` SET `views` = (`views` + 1) WHERE `id` = $book_id";
            $this->_model->query($query);
        }

        //Login facebook
        public function loginFacebookAction(){
            
            include_once "C:/xampp/htdocs/LiarsStore/define.php";
            include_once PATH_EXTENDS .DS . "Facebook/autoload.php";
            $fb = new Facebook\Facebook(
                [
                    "app_id" => APP_ID, 						//my app id
                    'app_secret' => APP_SECRET,					//my app secret
                    'default_graph_version' => "v3.2", 			//current version
                ]
            );
            $URLCallback        = "http://localhost//LiarsStore/index.php?module=client&controller=index&action=URLCallbackFaceook";
            $helper 		    = $fb->getRedirectLoginHelper();
            // $permissions 	= ['email', 'id', 'name', 'picture'];
            echo $loginUrl 		= $helper->getLoginUrl($URLCallback);
        }

        public function URLCallbackFaceookAction(){
            include_once "C:/xampp/htdocs/LiarsStore/define.php";
            include_once PATH_EXTENDS .DS . "Facebook/autoload.php";
            $fb = new Facebook\Facebook(
                [
                    "app_id" => APP_ID, 						//my app id
                    'app_secret' => APP_SECRET,					//my app secret
                    'default_graph_version' => "v3.2", 			//current version
                ]
            );
            
            $helper 		= $fb->getRedirectLoginHelper();

            try {
                $accessToken = $helper->getAccessToken();
                if($accessToken){
                    $_SESSION["access_token"] = $accessToken;
            
                    //Lấy thông tin của người dùng trên Facebool
                    $response 	= $fb->get('/me?fields=name,email', $accessToken->getValue());
                    $fbUser 	= $response->getGraphUser();
                    if(!empty($fbUser)){
                        //Người dùng không có email
                        if(!isset($fbUser["email"])){
                            $_SESSION["msg"] 	= "Tài khoản facebook của bạn chưa cập nhật email!";
                        }
                        $_SESSION["userLogin"]["infoUser"]["username"]  	= $fbUser["name"];
                        $_SESSION["userLogin"]["infoUser"]["email"] 		= $fbUser["email"];
                        $_SESSION["userLogin"]["infoUser"]["status"] 		= 1;
                        $_SESSION["userLogin"]["infoUser"]["group_acp"] 	= 0;
                        $_SESSION["userLogin"]["infoUser"]["avatar"] 	    = "";
                        $_SESSION["userLogin"]["infoUser"]["fullname"] 	    = $fbUser["name"];
                        $_SESSION["userLogin"]["isLogin"]                   = 1;
                        $_SESSION["userLogin"]["timeLogin"]                 = time();
                        //redirect
                        header("location: index.php");
                        exit();
                    }
                    
                }
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                  // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                  // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        
        }

        //SAVE CHANGE CONFIG READ BOOK
        public function saveChangeReadBookAction(){
            if(!empty($_POST)){
                setcookie("configReadBook", serialize($_POST));
            }
        }
        public function defaultChangeReadBookAction(){
            // if(isset($_SESSION["configReadBook"])) unset($_SESSION["configReadBook"]);
            if(isset($_COOKIE["configReadBook"])) setcookie("configReadBook", "", time() - 3600);
        }
    }