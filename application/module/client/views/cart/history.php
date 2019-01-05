<?php


?>

<div class="col-sm-8">
    <div class="movie-list-index home-v2">
        <div class="block update">
            <div class="widget-title">
                <h3 class="title">CART HISTORY</h3> 
            </div><!-- end widget-title -->
            <div class="clear"></div>
            
            <div class="col-md-8">
            
            <?php
                foreach($this->listBook as $key => $value):
                    $ids            = json_decode($value["books"]);
                    $arr_name       = json_decode($value["names"]);
                    $arr_prices     = json_decode($value["prices"]);
                    $arr_quantities = json_decode($value["quantities"]);
                    $arr_pictures   = json_decode($value["pictures"]);
                    $date           = date("d-m-Y H:i:s", strtotime($value["date"]));
                    $status         = ($value["status"] == 0) ? "Unconfirmed" : "Conformed";
            ?> 
            <div class="box box-info" style="margin-bottom: 30px;">
                <!-- TABLE -->
                <div class="box-body table-responsive">
                    <div id="" class="dataTables_wrapper form-inline" role="grid">
                        <table id="book_in_cart" class="table table-bordered dataTable text-center">
                            <?php echo '<span class="lael label-info info-history-head">ID: '.$value["id"].' | '.$status.'</span>'; ?>
                            <thead>
                                <tr role="row">
                                    <th class="sorting">Name</th>
                                    <th class="sorting" width="12%">Picture</th>
                                    <th class="sorting" width="6%">Quantity</th>
                                    <th class="sorting" width="12%">Amount</th>
                                    <th class="sorting" width="16%">Date</th>
                                </tr>
                            </thead>                       
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <?php foreach($ids as $keyC => $valueC):
                                    $linkDetail = URL::createURL("client", "index", "detail", array("id" => $valueC));
                                    $picture    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $arr_pictures[$keyC]);
                                ?>
                                <tr class="odd" id="book-in-cart-<?php echo $valueC?>">
                                    <td class="">
                                        <div class="col-md-12">
                                            <a href="<?php echo $linkDetail ?>"><?php echo $arr_name[$keyC] ?></a>
                                        </div>
                                    </td>
                                    <td class="show_picture_<?php echo $valueC?>"><img src="<?php echo $picture ?>"></td>
                                    <td class="show_quantity_<?php echo $valueC?>"><?php echo $arr_quantities[$keyC] ?></td>
                                    <td class="show_price_<?php echo $valueC?>">
                                        <div class=""><?php echo number_format($arr_prices[$keyC]) ?></div>
                                    </td>
                                    <td class="show_date_<?php echo $valueC?>">
                                        <div class=""><?php echo $date?></div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
            ?>
            <!--  END TABLE -->
            <!-- </div> -->
            <div class="clear"></div>
            <!-- PAGINATION --> 
            <div class="col-md-12 wrap-pagination">
                <?php
                    echo $this->pagination->showPaginationDF(null);
                ?>
            </div>
        </div>
        </div><!-- end block -->
    </div>
</div><!-- end col-lg-8 -->	
