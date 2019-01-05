<?php
    class ChapterController extends Controller{
        public function __construct($params){
            parent::__construct($params);
            $this->_templateObj->setFileConfig("templateUser.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();
        }

        public function indexAction(){
            //Paging
            // $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            // $this->setPagination();
            // $pagination = new Pagination($totleItem, $this->_pagination);
            // $this->_view->pagination = $pagination;

            //List chapter
            $listChapter = $this->_model->listItem($this->_params);
            $this->_view->listChapter = $listChapter;
            $infoBook = $this->_model->infoBook($this->_params);
            $this->_view->infoBook = $infoBook;
            
            //List group
            // $listGroup = $this->_model->listGroup($this->_params);
            // $this->_view->_listGroup = $listGroup;

            $this->_view->render("chapter/index", true);
        }

        /*public function formAction(){
            $listCategory = $this->_model->listCategory($this->_params);
            $this->_view->_listCategory = $listCategory;
            

            if(isset($this->_params["form"])){
                URL::checkRefreshForm($this->_params["token"], "admin", "chapter", "form");
            }else{
                Session::delete("token");
            }

            if(isset($this->_params["id"])){
                $infoChapterEdit = $this->_model->infoItem($this->_params);
                $this->_view->validItem                 = $infoChapterEdit;
                $this->_view->defaultItem["picture"]    = $infoChapterEdit["picture"];
            }

            if(isset($_SESSION["token"])){
                //EDIT

               //ADD
                $form_chapter   = $this->_params["form"];
                $validate    = new Validate($form_chapter);
                
                $queryN = "SELECT * FROM `chapter` WHERE `name` = '" . $form_chapter["name"] . "'";
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
                        $fileNameUpload = $upload->uploadFile($_FILES["picture"], "chapter", 98, 150);
                        $this->_params["form"]["picture"]       = $fileNameUpload;
                        $this->_view->defaultItem["picture"]    = $fileNameUpload;
                    }
                }
                
                if($validate->isValid()){
                    if(!isset($this->_params["id"])){
                        $affectedRows = $this->_model->insertChapter($this->_params["form"]);
                    }else{
                        $affectedRows = $this->_model->updateChapter($this->_params);
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
            $this->_view->render("chapter/form", true);
        }*/

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "chapter", "index");
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
            URL::redirect("admin", "chapter", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "chapter", "index");
        }

        //Add chapter
        public function addChapterAction(){
            if(isset($this->_params["form"])){
                $affectedRows = $this->_model->addChapter($this->_params);
                Helper::setSessionAffectedRows($affectedRows, "msg");
            }
            $this->_view->render("chapter/addChapter");
        }

        //EDIT CHAOTER
        public function editChapterAction(){
            $this->_view->infoChapter = $this->_model->infoChapter($this->_params);
            if(isset($this->_params["form"])){
                $affectedRows = $this->_model->editChapter($this->_params);
                Helper::setSessionAffectedRows($affectedRows, "msg");
            }
            $this->_view->render("chapter/edit");
        }

        //DELETE CHAPTER
        public function deleteChapterAction(){
            if(isset($this->_params["chapter_id"])){
                $chapter_id  = $this->_params["chapter_id"];
                $book_id     = $this->_params["book_id"];
                $query = "DELETE FROM `book_chapter` WHERE `id` = '$chapter_id'";
                $affectedRows = $this->_model->executeAndReturnAffectedRows($query);
                // Helper::setSessionAffectedRows($affectedRows, "msg");
                URL::redirect("admin", "chapter", "index", array("book_id" => $book_id));
            }
        }


    }