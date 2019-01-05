<?php
    class AnalyticsController extends Controller{
        public function __construct($params){
            parent::__construct($params);
            $this->_templateObj->setFileConfig("templateAnalytics.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("admin/main");
            $this->_templateObj->load();
        }

        public function overviewAction(){
            //TOTAL
            $this->_view->allTotalAmount = $this->_model->totalAmoutInAll();
            
            $this->_view->render("analytics/overview");
        }

        public function chartAction(){
            $this->_view->render("analytics/chart");
        }
    }
?>