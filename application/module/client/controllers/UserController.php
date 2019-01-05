<?php
    class UserController extends Controller{
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
            $this->_view->_title= "My Account";

            $this->_view->render("user/index");
        }

        public function changeInfoAction(){
            if(isset($this->_params["columnChange"])){
                $this->_model->changeInfo($this->_params);
            }
        }
        public function changePasswordAction(){
            if($this->_params["oldPassword"] != $this->_params["newPassword"]){
                $this->_model->changePassword($this->_params);
            }
        }

        //AJAX CHECK FORM
        public function ajaxCheckFormAction(){
            echo '<pre style=color:#176F08;font-weight:bold >';
            print_r($this->_params);
            echo '</pre>';
            // $this->_model->ajaxCheckForm($this->_params);
        }

        //Change avatar
        public function changeAvatarAction(){
            //Upload pictrure
            if(isset($_FILES["avatar"])){
                if($_FILES["avatar"]["error"] == 0){
                    include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                    $upload         = new Upload();
                    $fileNameUpload = $upload->uploadFile($_FILES["avatar"], "user", 98, 150, "only-max");
                    $this->_params["form"]["avatar"]       = $fileNameUpload;
                    $this->_view->defaultItem["avatar"]    = $fileNameUpload;

                    $_SESSION["userLogin"]["infoUser"]["avatar"] = $fileNameUpload;
                    $this->_model->changeAvatar($fileNameUpload);
                }
            }
            URL::redirect("client", "user", "index");
        }
        
    }