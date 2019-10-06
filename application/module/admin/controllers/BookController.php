<?php
    class BookController extends Controller{
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

            //List book
            $listBook = $this->_model->listItem($this->_params);
            $this->_view->listBook = $listBook;
            
            //List group
            $listGroup = $this->_model->listGroup($this->_params);
            $this->_view->_listGroup = $listGroup;

            $this->_view->render("book/index", true);
        }

        public function formAction(){
            $listCategory = $this->_model->listCategory($this->_params);
            $this->_view->_listCategory = $listCategory;
            

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["token"], "admin", "book", "form");
            }else{
                Session::delete("token");
            }

            if(isset($this->_params["id"])){
                $infoBookEdit = $this->_model->infoItem($this->_params);
                $this->_view->validItem                 = $infoBookEdit;
                $this->_view->defaultItem["picture"]    = $infoBookEdit["picture"];
            }

            if(isset($_SESSION["token"])){
                //EDIT

               //ADD
                $form_book   = $this->_params["form"];
                $validate    = new Validate($form_book);
                
                $queryN = "SELECT * FROM `book` WHERE `name` = '" . $form_book["name"] . "'";
                if(isset($this->_params["id"])){
                    $queryN .= " AND id != '" . $this->_params["id"] . "'";
                }

                $validate->addRule("name", "string-existsRecord", array("model" => $this->_model, "query" => $queryN, "min" => "2", "max" => "100"))
                         ->addRule("category_id", "status", array("deny" => array("default")))
                         ->addRule("status", "status", array("deny" => array("default")))
                         ->addRule("special", "status", array("deny" => array("default")))
                         ->addRule("ordering", "number", array("min" => 1,  "max" => 20))
                         ->addRule("sale_off", "number", array("min" => 0,  "max" => 100))
                         ->addRule("price", "number", array("min" => 1000,  "max" => 2000000));
                $validate->run();

                //Upload pictrure
                if(isset($_FILES["picture"])){
                    if($_FILES["picture"]["error"] == 0){
                        include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                        $upload         = new Upload();
                        $fileNameUpload = $upload->uploadFile($_FILES["picture"], "book", 98, 150);
                        $this->_params["form"]["picture"]       = $fileNameUpload;
                        $this->_view->defaultItem["picture"]    = $fileNameUpload;
                    }
                }
                
                if($validate->isValid()){
                    if(!isset($this->_params["id"])){
                        $affectedRows = $this->_model->insertBook($this->_params["form"]);
                    }else{
                        $affectedRows = $this->_model->updateBook($this->_params);
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
            $this->_view->render("book/form", true);
        }

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "book", "index");
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
            URL::redirect("admin", "book", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "book", "index");
        }
        
    }