<aside class="right-side">
    <?php
        
        
        if(!empty( @$this->infoBook )){
            $book_name          = $this->infoBook["name"];
            $book_id            = $this->infoBook["id"];
            $book_des           = Helper::sliceStr(Helper::convertDescript($this->infoBook["book_descript"]), 10);
            $book_picure        = Helper::createPathPicture(PATH_PICTURE_BOOK, URL_PICTURE_BOOK, "maxResize", $this->infoBook["picture"]);
            $url_edit_book      = URL::createURL("admin", "book", "form", array("id" => $book_id));
        }

        $xChapter = '';
        if(!empty( @$this->listChapter )){
            foreach($this->listChapter as $key => $value){
                $content_chapter = Helper::sliceStr(Helper::convertDescript($value["content_chapter"]),20);
                $url_edit        = URL::createURL("admin", "chapter", "editChapter", array("book_id" => $book_id, "chapter_id" => $value["id"]));
                $url_delete      = URL::createURL("admin", "chapter", "deleteChapter", array("chapter_id" => $value["id"], "book_id" => $book_id));
                $xChapter .= '<div class="block-info" style="padding: 20px">
                                <div class="col-md-2 text-left"><a href="#">Chapter '.$value['chapter_number'].'</a></div>
                                <div class="col-md-8 text-left">'.$content_chapter.'</div>
                                <div class="col-md-2 text-right">
                                    <a href="'.$url_edit.'" class="edit-chapter-'.$value["id"].'"><i class="fa fa-pencil"></i></a> | 
                                    <a href="'.$url_delete.'" class="delete-chapter-action delete-chapter-'.$value["id"].'"><i class="fa fa-trash-o"></i></a>
                                </div>
                            </div>
                            ';
            }
        }
    ?>
    <section class="content-header">
        <h1>
            Book
            <small>something</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Book</li>
        </ol>

        <!-- BUTTON APP -->
        <!-- <div class="row">
            <div class="main-button text-center" style="margin-top:30px">
                <a class="btn btn-app" href="javascript:reload()">
                    <i class="fa fa-refresh"></i> Reload
                </a>
                <a class="btn btn-app" href="<?php echo $url_add ?>">
                    <i class="fa fa-plus"></i> Add
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
        </div> -->

        <div class="wrap-info-book-picture" style="">
            <img class="info-book-picture" id="preview_picture" src="<?php echo $book_picure?>" alt="">
        </div>
        <div class="col-sm-12" style="margin: 76px 0px;">
            <div class="mark-animation"></div>
            <div class="" id="book-box">
                <div style="display: block; color: #076b49">
                    <div class="modal-info-book-chapter">
                        <div class="modal-content" style="background-color: #1C1C1C;">
                            <div class="modal-header">
                                <h4 class="modal-title book-name" style=""><?php echo $book_name?> &nbsp;<a href="<?php echo $url_edit_book ?>"><i class="fa fa-pencil"></i></a></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo $xChapter;?>
                            </div>
                        </div>
                    </div><!--  end modal login -->
                </div>
            </div>
        </div>

    </section>
</aside>
 