<?php
    class CategoryController extends Controller{
        private $arr_category;
        public function __construct($params){        
            parent::__construct($params);
            $this->_templateObj->setFileConfig("templateUser.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();
            include_once PATH_EXTENDS . DS . "XML/XML.php";
        }

        public function indexAction(){
            //Paging
            $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            $this->setPagination();
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List category
            $listCategory = $this->_model->listItem($this->_params);
            $this->_view->listCategory = $listCategory;

            $this->_view->render("category/index", true);
        }

        public function formAction(){
            

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["token"], "admin", "category", "form");
            }else{
                Session::delete("token");
            }

            if(isset($this->_params["id"])){
                $infoCategoryEdit = $this->_model->infoItem($this->_params);
                $this->_view->validItem                 = $infoCategoryEdit;
                $this->_view->defaultItem["picture"]    = $infoCategoryEdit["picture"];
            }

            if(isset($_SESSION["token"])){
                //XML
                include_once PATH_EXTENDS . DS . "XML/XML.php";
               //ADD
                $form_category   = $this->_params["form"];
                $validate        = new Validate($form_category);
                
                $queryN = "SELECT * FROM `category` WHERE `name` = '" . $form_category["name"] . "'";
                if(isset($this->_params["id"])){
                    $queryN .= " AND id != '" . $this->_params["id"] . "'";
                }

                $validate->addRule("name", "string-existsRecord", array("model" => $this->_model, "query" => $queryN, "min" => "2", "max" => "10"))
                         ->addRule("status", "status", array("deny" => array("default")))
                         ->addRule("ordering", "number", array("min" => 1,  "max" => 20));
                $validate->run();

                //Upload pictrure
                if(isset($_FILES["picture"])){
                    if($_FILES["picture"]["error"] == 0){
                        include_once PATH_EXTENDS . DS . "UploadFile/upload.php";
                        $upload         = new Upload();
                        $fileNameUpload = $upload->uploadFile($_FILES["picture"], "category");
                        $this->_params["form"]["picture"]       = $fileNameUpload;
                        $this->_view->defaultItem["picture"]    = $fileNameUpload;
                    }
                }

                if($validate->isValid()){
                    if(!isset($this->_params["id"])){
                        $affectedRows = $this->_model->insertCategory($this->_params["form"]);
                    }else{
                        $affectedRows = $this->_model->updateCategory($this->_params);
                    }   
                    //Write to XML
                    $this->arr_category = $this->_model->listCategory($this->_params);
                    XML::createXML($this->arr_category, "category");
                    Helper::setSessionAffectedRows($affectedRows, "msg");
                }else{
                    echo '<pre style=color:#176F08;font-weight:bold >';
                    print_r($validate->getErrors());
                    echo '</pre>';
                }
                $this->_view->validItem = $validate->getValidItem(); 
            }
            $this->_view->render("category/form", true);
        }

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            $this->arr_category = $this->_model->listCategory($this->_params);
            XML::createXML($this->arr_category, "category");
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "category", "index");
        }

        //AJAX CHECK FORM
        public function ajaxCheckFormAction(){
            $this->_model->ajaxCheckForm($this->_params);
        }
        
        //Change stauts by ajax
        public function changeStatusAction(){
            $this->_model->ajaxChangeStatus($this->_params);
            
            $this->arr_category = $this->_model->listCategory($this->_params);
            XML::createXML($this->arr_category, "category");
        }

        //Change ordering by ajax
        public function changeOrderingAction(){
            $this->_model->ajaxChangeOrdering($this->_params);
            $this->arr_category = $this->_model->listCategory($this->_params);
            XML::createXML($this->arr_category, "category");
        }

        //Multi Public
        public function multiPublicAction(){
            $affectedRows = $this->_model->multiPublic($this->_params);
            $this->arr_category = $this->_model->listCategory($this->_params);
            XML::createXML($this->arr_category, "category");
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "category", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            $this->arr_category = $this->_model->listCategory($this->_params);
            XML::createXML($this->arr_category, "category");
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "category", "index");
        }
    }