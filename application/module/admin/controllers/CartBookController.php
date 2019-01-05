<?php
    class CartBookController extends Controller{
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
            $this->setPagination(array("totalItemPerPage" => 10, "pageRange" => 3));
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List book
            $listCart = $this->_model->listItem($this->_params);
            $this->_view->listCart = $listCart;
            
            //List group
            $listGroup = $this->_model->listGroup($this->_params);
            $this->_view->_listGroup = $listGroup;

            $this->_view->render("cart-book/index", true);
        }

        //DELETE
        public function multiDeleteAction(){
            $affectedRows = $this->_model->deleteMulti($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "cart-book", "index");
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
            URL::redirect("admin", "cart-book", "index");
        }

        //Multi ubpublic
        public function multiUnpublicAction(){
            $affectedRows = $this->_model->multiUnpublic($this->_params);
            Helper::setSessionAffectedRows($affectedRows, "msg");
            URL::redirect("admin", "cart-book", "index");
        }
    }