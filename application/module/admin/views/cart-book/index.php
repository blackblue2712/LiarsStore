<aside class="right-side">
<?php
    
    $url_add            = URL::createURL("admin", "cart-book", "form");
    $url_edit           = URL::createURL("admin", "cart-book", "form");
    $url_delete         = URL::createURL("admin", "cart-book", "delete");
    $url_multiDelete    = URL::createURL("admin", "cart-book", "multiDelete");
    $url_multiPublic    = URL::createURL("admin", "cart-book", "multiPublic");
    $url_multiUnpublic  = URL::createURL("admin", "cart-book", "multiUnpublic");

    //
    $column         = isset($this->params["filter_column"]) ? $this->params["filter_column"] : "";
    $column_dir     = isset($this->params["filter_column_dir"]) ? $this->params["filter_column_dir"] : "";
    $lbName         = Helper::cmsLinkSort("Username", "username", $column, $column_dir);
    $lbPicture      = Helper::cmsLinkSort("Picture", "pictures", $column, $column_dir);
    $lbPrices        = Helper::cmsLinkSort("Price", "prices", $column, $column_dir);

    $lbStatus       = Helper::cmsLinkSort("Status", "status", $column, $column_dir);
    $lbQuantities   = Helper::cmsLinkSort("Qantities", "quantities", $column, $column_dir);
    $lbNameBooks    = Helper::cmsLinkSort("Name Book", "names", $column, $column_dir);
    $lbDate         = Helper::cmsLinkSort("Date", "date", $column, $column_dir);
    
    $lbId           = Helper::cmsLinkSort("ID", "id", $column, $column_dir);


    //Store  content_search
    $content_search = isset($this->params["content_search"]) ? $this->params["content_search"] : "";


    //MESSAGE
    $msg = "";
    if(isset($_SESSION["msg"])){
        $msg = Session::get("msg");
        $msg = '<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Alert!</b> '.$msg.'
            </div>';
        Session::delete("msg");
    }
    
?>
    <section class="content-header">
        <h1>
            Book
            <small>in Cart</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Shopping cart</li>
        </ol>

        <!-- BUTTON APP -->
        <div class="row">
            <div class="main-button text-center" style="margin-top:30px">
                <a class="btn btn-app" href="javascript:reload()">
                    <i class="fa fa-refresh"></i> Reload
                </a>
                <a class="btn btn-app present-custom-checkall" href="#">
                    <input type="checkbox" id="check-all" class="custom-checkall">
                    <i class="fa fa-plus"></i> Check All
                </a>
                <a class="btn btn-app" href="javascript:publicMulti('<?php echo $url_multiPublic?>')">
                    <i class="fa fa-check"></i> Publish
                </a>
                <a class="btn btn-app" href="javascript:unpublicMulti('<?php echo $url_multiUnpublic?>')">
                    <i class="fa fa-circle-o"></i> Unpublish
                </a>
                <a role="delete" id="delete" class="btn btn-app deleteMulti" href="javascript:deleteMulti('<?php echo $url_multiDelete ?>')">
                    <i class="fa fa-minus"></i> Delete
                </a>   
            </div>
        </div>
        <!-- ALERT MESSAGE -->
        <div class="message_alert">
            <?php echo $msg?>
        </div>



            <form action="#" id="adminForm" method="POST">
                <!-- TABLE CONTENT -->
                <?php
                    foreach($this->listCart as $key => $value):
                        $ids            = json_decode($value["books"]);
                        $arr_name       = json_decode($value["names"]);
                        $arr_prices     = json_decode($value["prices"]);
                        $arr_quantities = json_decode($value["quantities"]);
                        $arr_pictures   = json_decode($value["pictures"]);
                        $date           = date("d-m-Y H:i:s", strtotime($value["date"]));
                        $usernname      = $value["username"];
                        $totalPrice     = 0;
                        $status         = ($value["status"] == 1)? Helper::createPublicHTMLA( array("element" => "status", "id" => $value["id"], "controller" => "cart-book"  )) : Helper::createUnpublicHTMLA( array("element" => "status", "id" => $value["id"], "controller" => "cart-book") );
                ?> 
                <div class="box box-info" style="margin-bottom: 30px;">
                    <!-- TABLE -->
                    <div class="box-body table-responsive">
                        <div id="" class="dataTables_wrapper form-inline" role="grid">
                            <table id="book_in_cart" class="table table-bordered dataTable text-center">
                                <?php echo '<span class="lael label-info info-history-head">ID: '.$value["id"].'</span>'; ?>
                                <thead>
                                    <tr role="row">
                                        <td class="" width="3%"><input name="multi_select[] " type="checkbox" value="<?php echo $value["id"] ?>" id=""></td>
                                        <th class="sorting" width="6%"><?php echo $lbName?></th>
                                        <th class="sorting" width="16%"><?php echo $lbNameBooks?></th>
                                        <th class="sorting" width="12%"><?php echo $lbPicture?></th>
                                        <th class="sorting" width="6%"><?php echo $lbStatus?></th>
                                        <th class="sorting" width="6%"><?php echo $lbQuantities?></th>
                                        <th class="sorting" width="12%"><?php echo $lbPrices?></th>
                                        <th class="sorting" width="10%"><?php echo $lbDate;?></th>
                                    </tr>
                                </thead>                       
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php foreach($ids as $keyC => $valueC):
                                        $totalPrice += $arr_prices[$keyC];
                                        $linkDetail = URL::createURL("client", "index", "detail", array("id" => $valueC));
                                        $picture    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "98x150-", $arr_pictures[$keyC]);
                                    ?>
                                    <tr class="odd" id="book-in-cart-<?php echo $value["id"]?>">
                                        <td class="">
                                            <!-- <input type="checkbox" name="multi_select[]" value="<?php echo $value["id"] ?>"> -->
                                        </td>
                                        <td class="show_username_<?php echo $value["id"]?>"> <?php echo $usernname ?> </td>
                                        <td class="">
                                            <div class="col-md-12">
                                                <a href="<?php echo $linkDetail ?>"><?php echo $arr_name[$keyC] ?></a>
                                            </div>
                                        </td>
                                        <td class="show_picture_<?php echo $value["id"]?>"><img src="<?php echo $picture ?>"></td>
                                        <td class="show_status_<?php echo $value["id"]?>"><?php echo $status ?></td>
                                        <td class="show_quantity_<?php echo $value["id"]?>"><?php echo $arr_quantities[$keyC] ?></td>
                                        <td class="show_price_<?php echo $value["id"]?>">
                                            <div class=""><?php echo number_format($arr_prices[$keyC]) ?></div>
                                        </td>
                                        <td class="show_date_<?php echo $valueC?>">
                                            <div class=""><?php echo $date?></div>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="show_total_price" colspan=8>
                                            <div class="">Total: <?php echo number_format($totalPrice)?></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>





                <!-- END TABLE -->

                <!-- FILTER -->
                <input type="hidden" name="filter_special" value="default">
                <input type="hidden" name="filter_status" value="default">
                <input type="hidden" name="filter_column" value="date">
                <!-- Đặt giống ở model để pagination -->
                <input type="hidden" name="filter_column_dir" value="desc">
                <input type="hidden" name="filter_typing" value="name">
                <input type="hidden" name="filter_page" value="1">
            </form>
            <!-- PAGINATION --> 
            <center style="margin-top:40px">
                <?php
                    echo $this->pagination->showPaginationDF(null);
                ?>
            </center>
           
            <!-- <iframe src="\LiarsStore\application\module\admin\views\group\paging\paging.php" style="width:100%" frameborder="0"></iframe> -->
            <!-- END PAGINATION -->
        </div>
    </section>
</aside>

<script type="text/javascript">
    window.onload = function(){
        $("div.alert").delay(5000).slideUp();
    }

    <?php

        if(isset($this->params["filter_column"])){
            echo Helper::createScriptSort($column, $column_dir);
        }
    ?>
</script>

<?php
    // Gắn lại các select
    if(isset($this->params["select_filter_special"])){
        if($this->params["select_filter_special"] != "default")
        echo Helper::createScriptSelected("#select_filter_special", $this->params["select_filter_special"]);
    }
    // Gắn lại các select
    if(isset($this->params["select_filter_status"])){
        if($this->params["select_filter_status"] != "default")
        echo Helper::createScriptSelected("#select_filter_status", $this->params["select_filter_status"]);
    }
?>