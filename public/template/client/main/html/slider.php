<?php
    $xhtml = "";
    foreach($this->listRandom as $key => $value){
        $linkDetail = URL::createURL("client", "index", "detail", array("id" => $value["id"]));
        $picture  = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $value["picture"]);

        $name           = htmlentities(stripcslashes(Helper::sliceStr($value["name"], 3)));
        $value["name"]  = htmlentities(stripcslashes($value["name"]));
        $sale_off       = ($value["sale_off"] != 0) ? '<span style="display:none" class="ribbon status">-'.$value["sale_off"].'%</span>' : "";
        $xhtml .= '<li>
                        <a class="movie-item m-block" title="'.$value["name"].'" href="'.$linkDetail.'">
                            <div class="block-wrapper">
                                <div class="movie-thumbnail ratio-box ratio-3_4">
                                    <div class="public-film-item-thumb ratio-content" style="background-image:url('.$picture.')"></div>
                                </div>
                                <div class="movie-meta">
                                    <div class="movie-title-1">'.$name.'</div>
                                    <span class="movie-title-2">'.$value["name"].'</span>
                                    <span class="movie-title-chap">45758 </span>
                                    '.$sale_off.'
                                    <span style="display:none" class="ribbon ribbon-right right_price">'.number_format($value["price"]).'</span>
                                    
                                </div>
                            </div>
                        </a>
                    </li>';
    }
?>
<div class="row nominated-movie">
    <div class="col-lg-12">
        <h2 class="header-list-index" style="margin-top: 0px;"><span class="title-list-index">Phim đề cử</span></h2>
        <div class="top-movie-list ">
            <div class="list_carousel">
                <div class="caroufredsel_wrapper" style="display: block; text-align: start; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: auto; width: 792px; height: 251px; margin: 0px; overflow: hidden;">
                    <ul id="movie-carousel-top" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 2766px; height: 251px; z-index: auto;">
                        <?php echo $xhtml?>
                    </ul>
                </div>
                <div class="clear"></div>
                <a id="prevTop" class="prev" rel="nofollow" style="display: block;"><span class="arrow-icon left"></span></a>
                <a id="nextTop" class="next" rel="nofollow" style="display: block;"><span class="arrow-icon right"></span></a>
            </div>
        </div>
    </div>
</div>
<!-- END SLIDER -->
<script type="text/javascript">
    $(document).ready(function(){
        var li      = $("#movie-carousel-top").children();
        var firstli = li[0];
        var start   = 0;
        var showLi  = 5;
        var widthLi = $(firstli).outerWidth(true);
        var widthUl = widthLi * showLi;
        $("#nextTop").click(function(){
            $(this).hide();
            var liHide = [];
            var animate = $("#movie-carousel-top").animate({
                left    : "-=" + widthUl
            },800, function(){
                var li      = $("#movie-carousel-top").children();
                for(i = start; i < showLi; i++){
                    liHide[i] = li[i];
                    li[i].remove();
                }
                $("#movie-carousel-top").append(liHide);
                $("#movie-carousel-top").css("left", 0)
                $("#nextTop").show();
            })
        })
       

        $("#prevTop").click(function(e){
            $(this).hide();
            var liHide = [];
            var li       = $("#movie-carousel-top").children();
            var fiveLast = li.length - 5;
            for(i = fiveLast; i <= li.length; i++){
                liHide[i] = li[i];
            }
            $("#movie-carousel-top").prepend(liHide).show().promise().done(function(){
                $("#movie-carousel-top").css("left", -widthUl + "px")
                var animate = $("#movie-carousel-top").animate({
                    left    : "+=" + widthUl
                },800, function(){
                    $("#movie-carousel-top").css("left", 0)
                    $("#prevTop").show();
                })
            });
            e.preventDefault();
        })

    })
    
</script>