<?php
    class UserController extends Controller{
        public function __construct($params){
            parent::__construct($params);
            $this->_templateObj->setFileConfig("templateUser.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();
        }

        public function indexAction(){
            //Paging
            $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            $this->setPagination();
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List user
            $listUser = $this->_model->listItem($this->_params);
            $this->_view->listUser = $listUser;
            
            //List group
            $listGroup = $this->_model->listGroup($this->_params);
            $this->_view->_listGroup = $listGroup;

            $this->_view->render("user/index", true);
        }

        public function formAction(){
            $listGroup = $this->_model->listGroup($this->_params);
            $this->_view->_listGroup = $listGroup;
            

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["token"], "admin", "user", "form");
            }else{
                Session::delete("token");
            }

            if(isset($this->_params["id"])){
                $infoUserEdit = $this->_model->infoItem($this->_params);
                $this->_view->validItem = $infoUserEdit;
                $this->_view->defaultItem["picture"]    = $infoUserEdit["avatar"];
            }

            if(isset($_SESSION["token"])){
                //EDIT

               //ADD
                $form_user   = $this->_params["form"];
                $validate    = new Validate($form_user);
                
                $queryN = "SELECT * FROM `user` WHERE username = '" . $form_user["username"] . "'";
                $queryE = "SELECT * FROM `user` WHERE email = '" . $form_user["email"] . "'";
                if(isset($this->_params["id"])){
                    $queryN .= " AND id != '" . $this->_params["id"] . "'";
                    $queryE .= " AND id != '" . $this->_params["id"] . "'";
                }

                $validate->addRule("username", "string-existsRecord", array("model" => $this->_model, "query" => $queryN, "min" => "2", "max" => "20"))
                         ->addRule("email", "email-existsRecord", array("model" => $this->_model, "query" => $queryE))
                         ->addRule("group_id", "status", array("deny" => array("default")))
                         ->addRule("status", "status", array("deny" => array("default")))
                         ->addRule("ordering", "number", array("min" => 1,  "max" => 20));
                $validate->run();

                //Upload pictrure
                if(isset($_FILES["picture"])){
                    if($_FILES["picture"]["error"] == 0){
                        include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                        $upload         = new Upload();
                        $fileNameUpload = $upload->uploadFile($_FILES["picture"], "user", 98, 150, "only-max");
                        $this->_params["form"]["picture"]       = $fileNameUpload;
                        $this->_view->defaultItem["picture"]    = $fileNameUpload;

                        if(isset($_SESSION["userLogin"]["infoUser"]["avatar"]) && $_SESSION["userLogin"]["infoUser"]["id"] == $this->_params["id"]){
                            $_SESSION["userLogin"]["infoUser"]["avatar"] = $fileNameUpload;
                        }
                    }
                }
                
                if($validate->isValid()){
                    if(!isset($this->_params["id"])){
                        $affectedRows = $this->_model->insertUser($this->_params["form"]);
                    }else{
                        $affectedRows = $this->_model->updateUser($this->_params);
                    }
                    //
                    Helper::setSessionAffectedRows($affectedRows, "msg");
                }else{
                    echo '<pre style=color:#176F08;font-weight:bold >';
                    print_r($validate->getErrors());
                    echo '</pre>';
                }
                $this->_view->validItem = $validate->getValidItem(); 
            }
            $this->_view->render("user/form", true);
        }

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "user", "index");
        }

        //AJAX CHECK FORM
        public function ajaxCheckFormAction(){
            $this->_model->ajaxCheckForm($this->_params);
        }
        
        //Change stauts by ajax
        public function changeStatusAction(){
            $this->_model->ajaxChangeStatus($this->_params);
        }

        //Change ordering by ajax
        public function changeOrderingAction(){
            $this->_model->ajaxChangeOrdering($this->_params);
        }

        //Multi Public
        public function multiPublicAction(){
            $affectedRows = $this->_model->multiPublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "user", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "user", "index");
        }
    }