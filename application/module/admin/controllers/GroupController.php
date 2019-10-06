<?php
    class GroupController extends Controller{
        public function __construct($params){
            parent::__construct($params);
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();
        }

        public function indexAction(){
            $listGroup = $this->_model->listGroup($this->_params);
            $this->_view->_listGroup = $listGroup;

            //Paging
            $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            
            $this->setPagination();
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;
            
            $this->_view->listGroup = $this->_model->listItem($this->_params);

            $this->_view->_title = "Liars | Group";
            $this->_view->render("group/index", true);
        }

        public function formAction(){

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["token"], "admin", "group", "form");
            }else{
                Session::delete("token");
            }

            if(isset($this->_params["id"])){
                $infoGroupEdit = $this->_model->infoItem($this->_params);
                $this->_view->validItem = $infoGroupEdit;
            }

            if(isset($_SESSION["token"])){
                //EDIT

               //ADD
                $form_group  = $this->_params["form"];
                $validate    = new Validate($form_group);
                
                $query = "SELECT * FROM `group` WHERE name = '" . $form_group["name"] . "'";
                if(isset($this->_params["id"])){
                    $query .= " AND id != '" . $this->_params["id"] . "'";
                }

                $validate->addRule("name", "string-existsRecord", array("model" => $this->_model, "query" => $query, "min" => "2", "max" => "20"))
                         ->addRule("group_acp", "status", array("deny" => array("default")))
                         ->addRule("status", "status", array("deny" => array("default")))
                         ->addRule("ordering", "number", array("min" => 1,  "max" => 20));
                $validate->run();
                
                if($validate->isValid()){
                    if(!isset($this->_params["id"])){
                        $affectedRows = $this->_model->insertGroup($this->_params["form"]);
                    }else{
                        $affectedRows = $this->_model->updateGroup($this->_params);
                    }
                    //
                    $there = "is";
                    $row   = "row";
                    if($affectedRows > 1){
                        $there  = "are";
                        $row    = "rows";
                    }
                    Session::set("msg", "There $there $affectedRows $row afftected");
                }else{
                    echo '<pre style=color:#176F08;font-weight:bold >';
                    print_r($validate->getErrors());
                    echo '</pre>';
                }
                $this->_view->validItem = $validate->getValidItem(); 
            }
            $this->_view->render("group/form", true);
        }

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "group", "index");
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
            URL::redirect("admin", "group", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "group", "index");
        }
    }