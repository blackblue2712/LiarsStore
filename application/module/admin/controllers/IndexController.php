<?php
    class IndexController extends Controller{
        public function __construct($params){
            parent::__construct($params);
        }
        
        public function indexAction(){
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();

            $this->_view->render("index/index", true);
        }

        public function loginAction(){
            $this->_templateObj->setFileConfig("loginTemplate.ini");
            $this->_templateObj->setFileTemplate("login.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();

            if(isset($_SESSION["userLogin"]) && $_SESSION["userLogin"]["isLogin"] == 1){
                URL::redirect("admin", "index", "index");
            }

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["form"]["token"], "admin", "index", "login");                
            }

            if(isset($_SESSION["token"])){
                $validate = new Validate($this->_params["form"]);

                $username = $this->_params["form"]["username"];
                $password = md5($this->_params["form"]["password"]);

                $query = "SELECT * FROM user WHERE username = '$username' AND `password` = '$password' LIMIT 1";

                $validate->addRule("username", "existsRecord", array("model" => $this->_model, "query" => $query));
                $validate->run();
               if( $validate->isValid() ){
                    $infoUser        = $this->_model->getInfo($this->_params);
                    $array_session   = array(
                                        "infoUser"   => $infoUser,
                                        "isLogin"    => true,
                                        "timeLogin"  => time() 
                                    );
                   Session::set("userLogin", $array_session);
                   URL::redirect("admin", "index", "index");
               }else{
                   Session::set("msg", "Username or password was wrong");
               }
            }

            $this->_view->render("index/login");

        }

        // Log screen
        

        //Log out
        public function logoutAction(){
            Session::delete("userLogin");
            Session::delete("token");
            URL::redirect("admin", "index", "login");
        }

        
    }