<?php
    $xhtml = "";
    foreach($this->listSpecial as $key => $value){
        $linkDetail = URL::createURL("client", "index", "detail", array("id" => $value["id"]), "/detail-book-$value[id].html");
        $picture    = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);
        if($key == 0) $descript = "";
        else $descript   = Helper::sliceStr($value["book_descript"], 3);
        $sale_off   = ($value["sale_off"] != 0) ? '<span class="status">-'.$value["sale_off"].'%</span>' : "";
        $xhtml .= '<li class="list-top-movie-item" id="list-top-movie-item">
                        <a class="list-top-movie-link" title="'.$value["name"].'" href="'.$linkDetail.'">
                            '.$sale_off.'
                            <span class="right_price">'.number_format($value["price"]).'</span>
                            <div class="list-top-movie-item-thumb" style="background-image: url('.$picture.')"></div>
                            <div class="list-top-movie-item-info"><span class="list-top-movie-item-vn">'.$value["name"].'</span><span class="list-top-movie-item-en"> '.$descript.'</span><span class="list-top-movie-item-view">'.$value["views"].' Views</span></div>
                        </a>
                    </li>';
    }
?>
<div class="col-sm-4 sidebar" id="sidebar">
    <div class="right-box top-film">
        <h2 class="right-box-header star-icon"><span>TOP VIEW</span></h2>
        <span class="tabs">
            <div class="tab active" data-name="day" data-target=".right-box.top-film .content">
                <div class="name rank-views-in-day"><a title="Day" href="javascript:void(0)">Overall</a></div>
            </div>
        </span>
        <div class="right-box-content">
            <div class="content" data-name="day">
                <ul class="list-top-movie">
                    <?php echo $xhtml ?>
                </ul>
            </div>
        </div><!-- end right-box-content -->
    </div>
</div>