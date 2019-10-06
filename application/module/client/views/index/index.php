<?php

?>

<div class="col-sm-8">
    <div class="movie-list-index home-v2">
        <div class="block update">
            <div class="widget-title">
                <h3 class="title">New Book UPDATING</h3>
                <span class="tabs">
                    <div class="tab active" data-name="all" data-target=".block.update .content">
                        <div class="name"><a title="All" href="javascript:void(0)">Overall</a></div>
                    </div>
                    <div class="tab" data-name="muanay" data-target=".block.update .content"><div class="name">
                        <a title="anime mùa này" href="javascript:void(0)">Season</a></div>
                    </div>
                </span>
            </div><!-- end widget-title -->
            <div class="clear"></div>
            <div class="last-film-box-wrapper">
                <div class="content" data-name="all">
                    <ul class="last-film-box" id="movie-last-movie">
                        <?php
                            $xhtml = "";
                            if(!empty($this->listBook)){
                                foreach($this->listBook as $key => $value){
                                    $linkDetail = URL::createURL("client", "index", "detail", array("id" => $value["id"]), "/detail-book-$value[id].html");
                                    $picture    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);
                                    $sale_off   = ($value["sale_off"] != 0) ? '<span class="ribbon">-'.$value["sale_off"].'%</span>' : "";
                                    $xhtml .= '<li><a class="movie-item m-block" title="'.$value["name"].'" href="'.$linkDetail.'">
                                                <div class="block-wrapper">
                                                    <div class="movie-thumbnail ratio-box ratio-3_4">
                                                        <div class="public-film-item-thumb ratio-content" style="background-image:url('.$picture.')"></div>
                                                    </div>
                                                    <div class="movie-meta">
                                                        <div class="movie-title-1">'.$value["name"].'</div>
                                                        <span class="fbcom-left">548</span><span class="viewed-right">'.$value["views"].'</span>
                                                        '.$sale_off.'
                                                        <span class="ribbon ribbon-right">'.number_format($value["price"]).'</span>
                                                    </div>
                                                </div>
                                            </a></li>';
                                }
                            }else{
                                $xhtml = "<span style='background: url(/LiarsStore/public/loading/Interwind-1s-200px.gif) 21px center no-repeat;display: inline-block; padding: 30px 107px 30px 0px;'>Upading ...";
                            }
                            
                            echo $xhtml;
                        ?>
                        
                    </ul>
                    <!-- PAGINATION --> 
                    <div class="clear"></div>
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
