<?php
    $xPreview = '';
    if(!empty($this->chapterBook)){
        foreach($this->chapterBook as $key => $value){
            $id_book = $this->detailBook["id"];
            $chapter = $value["chapter_number"];
            $url_read = URL::createURL("client", "index", "readBook", array("id_book" => $this->detailBook["id"], "chapter" => $value["chapter_number"]), "/read-book-$id_book-$chapter.html");
            $xPreview .= '<li><a href="'.$url_read.'" title="'.$value["chapter_number"].'">'.$value["chapter_number"].'</a></li>';
        }
    }
    if(!empty($this->detailBook)){
        $infoBook       = $this->detailBook;
        $id_book        = $infoBook["id"];
        $url_addToCart  = URL::createURL("client", "cart-book", "addBook", array("id_book" => $id_book));
        $urlRelatedBook = URL::createURL("client", "index", "related", array("category_id" => $infoBook["category_id"], "id" => $infoBook["id"]) );
        $year           = Helper::convertTimeToYear($infoBook["created"]);
        $descript       = Helper::convertDescript($infoBook["book_descript"]);
        $picture        = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "", $infoBook["picture"]);
        $sale_off       = ($infoBook["sale_off"] != 0)? '<br><dt class="movie-dt">Sale off: </dt><dd class="movie-dd dd-cat"><a href="javascript:void(0)">'.$infoBook["sale_off"].'%</a></dd>' : '';
        $xDetail = '<h1 class="movie-title"><span class="title-1">'.$infoBook["name"].'</span><span class="title-2">'.$infoBook["name"].'</span><span class="title-year"> ('.$year.')</span></h1>
                    <div class="movie-meta-info">
                        <dl class="movie-dl">
                            <dt class="movie-dt">Status: </dt>
                            <dd class="movie-dd imdb">12/12</dd>
                            <br>
                            <dt class="movie-dt">Genres: </dt>
                            <dd class="movie-dd dd-cat"><a href="javascript:void(0)">'.$infoBook["category_name"].'</a></dd>
                            <br>
                            <dt class="movie-dt">Author: </dt>
                            <dd class="movie-dd dd-cat"><a href="javascript:void(0)">Updating</a></dd>
                            <br>
                            <dt class="movie-dt">Released: </dt>
                            <dd class="movie-dd dd-cat"><a href="javascript:void(0)">'.$year.'</a></dd>
                            <br>
                            <dt class="movie-dt">Price: </dt>
                            <dd class="movie-dd dd-cat"><a href="javascript:void(0)">'.number_format($infoBook["price"]).'</a></dd>
                            '.$sale_off.'
                            <br>	
                        </dl>
                        <div class="clear"></div>
                    </div>
                    <div class="box-rating">
                        <b><small>Read preview</small>
                            <div class="block2 servers">
                                <div class="server">
                                    <div class="episodes col-lg-12 col-md-12 col-sm-12">
                                        <ul class="chapter-book-all">
                                            '.$xPreview.'
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </b>
                    </div>';

        $xImg = '<div class="movie-l-img">
                    <img src="'.$picture.'" style="width:310px;height:377px;">
                    <ul class="btn-block">
                        <li class="item" style="position:absolute; left: 50px;">
                          <input name="form[quantity_book]" class="quantity_book" type="number" value="1">
                        </li>
                        <li class="item icon-cart">
                            <a id="btn-film-watch" class="btn btn-green" href="javascript:onOrder(\''.$url_addToCart.'\', '.$infoBook["price"].')"> <span class="fa  fa-plus-circle"></span> <span class="fa fa-shopping-cart"></span> </a>
                        </li>
                    </ul>
                </div>';
        
        $xDescript = '<blockquote class="block-movie-content block-movie-detail">
                        <span class="tabs tab-detail" style="display: block; left: 0">
                            <div class="tab active">
                                <div class="name"><a class="abstract" href="javascript:void(0)">Abstract</a></div>
                            </div>
                            <div class="tab">
                                <div class="name"><a class="related" href="javascript:relatedBook(\''.$urlRelatedBook.'\')">Related</a></div>
                            </div>
                        </span>
                        <div class="clear"></div>
                        <br>
                        <div class="content" id="film-content" itemscope="" itemtype="http://schema.org/Review" itemprop="review">
                            <div class="news-article" id="tab-abstract">
                                <p>'.$descript.'<br><br>(Source: MAL News)</p>
                            </div>
                            <div style="display:none" class="news-article" id="tab-related">
                                <div class="movie-list-index home-v2">
                                <div class="block update">
                                        <div class="last-film-box-wrapper">
                                            <div class="content" data-name="all">
                                                <ul class="last-film-box" id="movie-last-movie">
                                                    
                                                    <div class="clear"></div>                      
                                                </ul>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </blockquote>';
    }
?>

<div class="col-sm-8">
    <div class="movie-info">
        <div class="block-movie-info movie-info-box">
            <div class="block-wrapper page-single" itemscope="" itemtype="https://schema.org/Movie">
                <div class="movie-info">
                    <div class="block-movie-info movie-info-box">
                        <div class="row">
                            <div class="col-6 movie-detail">
                                
                            <?php echo $xDetail?>

                            </div>
                            <div class="col-6 movie-image">
                                <?php echo $xImg;?>
                            </div>
                        </div><!-- end row -->
                        
                        <!-- SUMARY -->
                        <blockquote class="block-movie-content">
                            <div class="content"><div id="div1"></div><div>
                            <div class="clear"></div>
                        </blockquote>
                        
                        <?php echo $xDescript?>

                    </div>
                </div><!-- end movie info -->
            </div>
        </div>
    </div>
</div>