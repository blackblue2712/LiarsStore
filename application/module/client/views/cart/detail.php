<?php
   $url_checkout = URL::createURL("client", "cart-book", "checkout");
?>

<div class="col-sm-8">
    <div class="movie-list-index home-v2">
        <div class="block update">
            <div class="widget-title">
                <h3 class="title">MY CART</h3> 
            </div><!-- end widget-title -->
            <div class="clear"></div>
            
            <div class="col-md-8">
            <div class="box box-info">
                
                <div class="box-body table-responsive">
                    <!-- TABLE CONTENT -->
                    <div id="" class="dataTables_wrapper form-inline" role="grid">
                        <form action="<?php echo $url_checkout ?>" method="POST" name="cart-form" id="cart-form">
                            <table id="book_in_cart" class="table table-bordered dataTable text-center">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting"><input type="checkbox" id="check-all" name=""></th>
                                        <th class="sorting" >Name</th>
                                        <th class="sorting" width="12%">Picture</th>
                                        <th class="sorting" width="12%">Quantity</th>
                                        <th class="sorting" width="12%">Amount</th>
                                        <th class="sorting" width="4%">Delete</th>
                                    </tr>
                                </thead>
                                <?php
                                    $i = 0;
                                    $xhtml = "";
                                    if(isset($this->listBook)){
                                        foreach($this->listBook as $key => $value){
                                            $class          = ($i % 2 == 0)? "even":"odd";
                                            $quantity   = $_SESSION["userLogin"]["cart"][$value["id"]]["quantity_book"];
                                            $price      = $_SESSION["userLogin"]["cart"][$value["id"]]["price"];
                                            $linkDetail = URL::createURL("client", "index", "detail", array("id" => $value["id"]));
                                            $picture    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);
                                            $sale_off   = ($value["sale_off"] != 0) ? '<span class="ribbon">-'.$value["sale_off"].'%</span>' : "";
                                            $xhtml .= '<tr class="'.$class.'" id="book-in-cart-'.$value["id"].'">
                                                        <td class=""><input name="form-cart[]" type="checkbox" value="'.$value["id"].'" readonly="readonly"></td>
                                                        <td class="">
                                                            <div class="col-md-12">
                                                                <a href = '.$linkDetail.'>'.$value["name"].'</a>
                                                            </div>
                                                        </td>
                                                        <td class="show_picture_'.$value["id"].'"><img src="'.$picture.'"></td>
                                                        <td class="show_quantity_'.$value["id"].'"><input data-id="'.$value["id"].'" type="number" class="input_quantity"  value="'.$quantity.'"></td>
                                                        <td class="show_price_'.$value["id"].'">
                                                            <div class="">'.number_format($price).'</div>
                                                        </td>
                                                        <td class=""><a href="javascript:onDeleteCart('.$value["id"].')"><span class="fa fa-trash-o"></span></a></td>
                                                    </tr>';
                                            $i++;
                                        }
                                        $xhtml .= '<tr><td class="totalAmount" colspan="6">Total: '.number_format($_SESSION["userLogin"]["totalAmount"]).'</td></tr>';
                                        $btn_checkout = '<button class="btn btn-danger checkout" id="submit-form-cart">Check out</button>';
                                    }else{
                                        $xhtml = "<h3 style='font-family: UTMCafetaRegular;'>Your cart is now empty</h3>";
                                        $btn_checkout = '';
                                    }
                                ?>
                                
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php echo $xhtml; ?>    
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                    <div class="clear"></div>
                    <div class="row text-center" style="margin-top: 40px">
                        <?php echo $btn_checkout ?>
                    </div>

                    <!-- PAGINATION --> 
                   <div class="col-md-12 wrap-pagination">
                        <?php
                            echo $this->pagination->showPaginationDF(null);
                        ?>
                   </div>
                </div>
            </div>
        </div><!-- end block -->
    </div>
</div><!-- end col-lg-8 -->	
