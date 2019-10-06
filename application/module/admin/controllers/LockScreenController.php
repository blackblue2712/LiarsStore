<?php  
    class LockScreenController extends Controller{
        public function indexAction(){
            $this->_templateObj->setFileConfig("templateLockScreen.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();

            $_SESSION["userLogin"]["isLogin"] = 2;
            unset($_SESSION["token"]);

            $this->_view->render("lock-screen/index", false);
        }
        //Ajax check password
        public function checkPasswordAction(){
            $isExists = $this->_model->ajaxCheckPassword();
            if($isExists == true){
                $_SESSION["userLogin"]["isLogin"] = 1;
                $_SESSION["combackFormLockscreen"] = 1;
            }
        }

        public function logoutAction(){
            Session::delete("userLogin");
            Session::delete("token");
            URL::redirect("admin", "index", "login");
        }
    }