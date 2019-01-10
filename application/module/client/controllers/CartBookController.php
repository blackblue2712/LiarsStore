<?php
    class CartBookController extends Controller{
        public function __construct($params){
            parent::__construct($params);

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
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("client/main");
            $this->_templateObj->load();

            //Paging
            $totleItem          = $this->_model->countItem($this->_params)["totalItem"];
            $this->setPagination(array("totalItemPerPage" => 12, "pageRange" => 3));
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List book
            $listBook = $this->_model->listItem($this->_params);
            $this->_view->listBook = $listBook;

            $this->_view->render("cart/index", true);
        }

        public function addBookAction(){
            $id_book        = $this->_params["id_book"];
            $infoBook       = $this->_model->getInfo( array("id" => $id_book) );

            $quantity_book  = $this->_params["quantity_book"];
            $price_book     = $infoBook["price"];
            $sale_off       = $infoBook["sale_off"];
            $name           = $infoBook["name"];
            $picture        = $infoBook["picture"];
            
            if(!isset($_SESSION["userLogin"]["cart"][$id_book])){
                $_SESSION["userLogin"]["cart"][$id_book]["quantity_book"] = $quantity_book;
                $price_not_sale_off                                       = $quantity_book * $price_book;
                $_SESSION["userLogin"]["cart"][$id_book]["price"]         = $price_not_sale_off - ($price_not_sale_off * $sale_off / 100);
            }else{
                $_SESSION["userLogin"]["cart"][$id_book]["quantity_book"] += $quantity_book;
                $price_not_sale_off                                       = $_SESSION["userLogin"]["cart"][$id_book]["quantity_book"] * $price_book;
                $_SESSION["userLogin"]["cart"][$id_book]["price"]         = $price_not_sale_off - ($price_not_sale_off * $sale_off / 100);
            }

            $_SESSION["userLogin"]["cart"][$id_book]["sale_off_just_to_update"] = $sale_off;
            $_SESSION["userLogin"]["cart"][$id_book]["price_just_to_update"]    = $price_book;
            $_SESSION["userLogin"]["cart"][$id_book]["name"]                    = $name;
            $_SESSION["userLogin"]["cart"][$id_book]["picture"]                 = $picture;

            $count   = 0;
            $amounts = 0;
            foreach($_SESSION["userLogin"]["cart"] as $key => $value){
                $count   += $value["quantity_book"];
                $amounts += $value["price"];
            }
            $_SESSION["userLogin"]["totalItemInCart"] = $count;
            $_SESSION["userLogin"]["totalAmount"]     = $amounts;

            echo json_encode( array("totalItemInCart" => $count, "totalAmount" => number_format($amounts)) );
        }

        public function detailAction(){
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("client/main");
            $this->_templateObj->load();

            //Paging
            $totleItem          = $this->_model->countItem();
            $this->setPagination(array("totalItemPerPage" => 12, "pageRange" => 3));
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List book
            $listBook = $this->_model->listItem($this->_params);
            $this->_view->listBook = $listBook;

            $this->_view->render("cart/detail", true);
        }

        public function updateCartAction(){
            
            $idUpdate = $this->_params["idUpdateQuantity"];
            if(isset( $_SESSION["userLogin"]["cart"][$idUpdate] )){
                $_SESSION["userLogin"]["cart"][$idUpdate]["quantity_book"] = $this->_params["quantityUpdate"];
                $price_not_sale_off = $this->_params["quantityUpdate"] * $_SESSION["userLogin"]["cart"][$idUpdate]["price_just_to_update"];
                $_SESSION["userLogin"]["cart"][$idUpdate]["price"]         = $price_not_sale_off - ($price_not_sale_off * $_SESSION["userLogin"]["cart"][$idUpdate]["sale_off_just_to_update"] / 100);

                $count   = 0;
                $amounts = 0;
                foreach($_SESSION["userLogin"]["cart"] as $key => $value){
                    $count   += $value["quantity_book"];
                    $amounts += $value["price"];
                }
                $_SESSION["userLogin"]["totalItemInCart"] = $count;
                $_SESSION["userLogin"]["totalAmount"]     = $amounts;

                echo json_encode( array("totalItemInCart" => $count, "totalAmount" => number_format($amounts), "priceUpdated" => number_format($_SESSION["userLogin"]["cart"][$idUpdate]["price"])) );
            }
        }

        public function deleteCartAction(){
            
            $idDelete = $this->_params["idDelete"];
            if(isset( $_SESSION["userLogin"]["cart"][$idDelete] )){
                unset($_SESSION["userLogin"]["cart"][$idDelete]);
                $count   = 0;
                $amounts = 0;
                foreach($_SESSION["userLogin"]["cart"] as $key => $value){
                    $count   += $value["quantity_book"];
                    $amounts += $value["price"];
                }
                $_SESSION["userLogin"]["totalItemInCart"] = $count;
                $_SESSION["userLogin"]["totalAmount"]     = $amounts;

                echo json_encode( array("totalItemInCart" => $count, "totalAmount" => number_format($amounts)) );
            }
        }

        public function checkoutAction(){
            if(isset($this->_params['form-cart']) && !empty($this->_params['form-cart']) ){
                $ids_book           = array();
                $names_book         = array();
                $pictures_book      = array();
                $quantities_book    = array();
                $time_checkout      = date("Y-m-d H:i:s");
                $user_checkout      = $_SESSION["userLogin"]["infoUser"]["username"];
                $iduser_checkout    = $_SESSION["userLogin"]["infoUser"]["id"];
                $user_cart          = $_SESSION["userLogin"]["cart"];

                $totalPirceCheckout  = 0;
                $totalBookCheckout  = 0;
                foreach($this->_params['form-cart'] as $value){
                    $ids_book[]         = $value;
                    $names_book[]       = $user_cart[$value]["name"];
                    $pictures_book[]    = $user_cart[$value]["picture"];
                    $quantities_book[]  = $user_cart[$value]["quantity_book"];
                    $prices_book[]      = $user_cart[$value]["price"];

                    $totalPirceCheckout = $totalPirceCheckout + $user_cart[$value]["price"];
                    $totalBookCheckout  = $totalBookCheckout + $user_cart[$value]["quantity_book"];

                    unset( $_SESSION["userLogin"]["cart"][$value] );
                }

                $_SESSION["userLogin"]["totalItemInCart"]   = $_SESSION["userLogin"]["totalItemInCart"] - $totalBookCheckout;
                $_SESSION["userLogin"]["totalAmount"]       = $_SESSION["userLogin"]["totalAmount"] - $totalPirceCheckout;

                if($_SESSION["userLogin"]["totalItemInCart"] == 0 ) unset($_SESSION["userLogin"]["totalItemInCart"]);
                if($_SESSION["userLogin"]["totalAmount"] == 0 ) unset($_SESSION["userLogin"]["totalAmount"]);

                $array_insert = array
                (
                    "id"            => Helper::createRandomCharacter(11),
                    "id_user"       => $iduser_checkout,
                    "username"      => $user_checkout,
                    "books"         => json_encode($ids_book),
                    "prices"        => json_encode($prices_book),
                    "quantities"    => json_encode($quantities_book),
                    "names"         => json_encode($names_book),
                    "pictures"      => json_encode($pictures_book),
                    "status"        => 0,
                    "date"          => $time_checkout,
                );
                
                $sqlInsert = $this->_model->createInsertSql($array_insert, "cart");
                $affectedRows = $this->_model->executeAndReturnAffectedRows($sqlInsert);
                URL::redirect("client", "cart-book", "detail", null, "/cart.html");
            }else{
                URL::redirect("client", "cart-book", "detail", null, "/cart.html");
            }
        }

        public function historyAction(){
            $this->_templateObj->setFileConfig("template.ini");
            $this->_templateObj->setFileTemplate("index.php");
            $this->_templateObj->setFolderTemplate("client/main");
            $this->_templateObj->load();

            //Paging
            $totleItem          = $this->_model->countItem();
            $this->setPagination(array("totalItemPerPage" => 12, "pageRange" => 3));
            $pagination = new Pagination($totleItem, $this->_pagination);
            $this->_view->pagination = $pagination;

            //List book
            $listBook = $this->_model->listItemHistory($this->_params);
            $this->_view->listBook = $listBook;

            $this->_view->render("cart/history", true);
        }

    }