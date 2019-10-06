<aside class="right-side">
<?php

    // echo '<pre style=color:#176F08;font-weight:bold >';
    // print_r($this->validItem);
    // echo '</pre>';
    $book_name     = (isset($this->validItem["name"]) ? $this->validItem["name"] : "");
    $book_name     = isset($this->validItem["book_name"]) ? $this->validItem["book_name"] : $book_name;

    $fullname      = isset($this->validItem["fullname"]) ? $this->validItem["fullname"] : "";
    $fullname      = isset($_POST["form"]["fullname"]) ? $_POST["form"]["fullname"] : $fullname;


    $book_ordering = isset($this->validItem["ordering"]) ? $this->validItem["ordering"] : "";
    $book_price    = isset($this->validItem["price"]) ? $this->validItem["price"] : "";
    $book_saleoff  = isset($this->validItem["sale_off"]) ? $this->validItem["sale_off"] : 0;
    $book_descript = isset($this->validItem["book_descript"]) ? Helper::convertDescript($this->validItem["book_descript"]) : "";
    $book_descript = isset($_POST["form"]["book_descript"]) ? Helper::convertDescript($_POST["form"]["book_descript"]) : $book_descript;

    $picture = isset($this->defaultItem["picture"]) ? URL_PICTURE_BOOK.DS."98x150-".$this->defaultItem["picture"] : "";
    if($picture != ""){
        echo Helper::createScript("$('img#preview_picture').show().css('display','block')");
    }
    
    //url
    $url_back       = URL::createURL("admin", "book", "index");

    //linkAjax check form
    $linkCheckBookName = URL::createURL("admin", "book", "ajaxCheckForm", array("table" => "book"));

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
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>

        <!-- BUTTON APP -->
        <div class="row">
            <div class="main-button text-center" style="margin-top:30px">
                <a class="submit-form btn btn-app">
                    <i class="fa fa-save"></i> Save
                </a>
                
                <a class="btn btn-app" href="<?php echo $url_back?>">
                    <i class="fa fa-arrow-left"></i> Back
                </a> 
            </div>
        </div>
        
        <?php
            echo $msg;
        ?>

        <!-- ALERT MESSAGE -->
        <div class="callout callout-danger" style="display:none">
            <h4>I am a danger callout!</h4>
            <p>May be you don't fill in the form or you edit the select tag by HTML. Please don't do it and fill in the form!</p>
        </div>

        <!-- FORM -->

        <div class="box box-primary" style="margin-top:20px">
            <form id="adminForm" name="adminForm" method="POST" enctype="multipart/form-data">
                <div  class="col-md-6">
                    <div class="box-body">
                        <!-- BOOK NAME -->
                        <div class="form-group">
                            <label for="name" class="require">Book name</label>
                            <input type="text" class="form-control" id="book_name" name="form[name]" placeholder="Enter book name" value="<?php echo $book_name ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        
                        <!-- PICTURE -->
                        <div class="form-group has-feedback">
                            <label style="display:block" for="name" class="avatar">Picture</label>
                            <input style="display:none" type="file" class="avatar" id="picture" name="picture" placeholder="Enter fullname" value="<?php echo $fullname ?>">
                            <a href="javascript:openFile()" class="choose_avatar"><i style="font-size: 100px; color: #ccc" class="fa fa-picture-o"></i></a>
                            <img src="<?php echo $picture ?>" id="preview_picture" style="display: none">
                        </div>
                        <!-- PRICE -->
                        <div class="form-group">
                            <label for="price" class="require">Price</label>
                            <input type="number" class="form-control" id="price" name="form[price]" placeholder="Enter price" value="<?php echo  $book_price ?>">
                        </div>
                        <!-- SALE OFF -->
                        <div class="form-group">
                            <label for="sale_off" class="require">Sale off (%)</label>
                            <input type="number" class="form-control" id="sale_off" name="form[sale_off]" placeholder="Enter sale off" value="<?php echo  $book_saleoff ?>">
                        </div>
                        <!-- SPECIAL -->
                        <div class="form-group">
                            <label style="display:block" for="special" class="require">Special</label>
                            <select name="form[special]" id="special">
                                <option value="default">--Select Special--</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <!-- STATUS -->
                        <div class="form-group">
                            <label style="display:block" for="status" class="require">Status</label>
                            <select name="form[status]" id="status">
                                <option value="default">--Select Status--</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <!-- CATEGORY_ID -->
                        <?php
                            $xCate = "";
                            if(!empty($this->_listCategory)){
                                foreach($this->_listCategory as $key => $value){
                                    $xCate .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                                }
                            }
                        ?>
                        <div class="form-group">
                            <label style="display:block" for="category_id" class="require">Category</label>
                            <select name="form[category_id]" id="category_id">
                                <option value="default">--Select Category--</option>
                                <?php echo $xCate ?>
                            </select>
                        </div>
                        <!-- ORDERING -->
                        <div class="form-group">
                            <label for="ordering" class="require">Ordering</label>
                            <input type="number" class="form-control" id="ordering" name="form[ordering]" placeholder="Enter ordering number" value="<?php echo  $book_ordering ?>">
                        </div>
                        
                        <input type="hidden" name="token" value="<?php echo time() ?>">
                    </div><!-- /.box-body -->
                </div><!-- md 6 -->
                <div class="col-md-12">
                    <!-- DESCRIPT -->
                    <div class="form-group">
                        <label>Descript</label>
                        <textarea id="descript_book" name="form[book_descript]" class="form-control" rows="3" placeholder="Enter ..."><?php echo $book_descript ?></textarea>
                        <p class="help-block">Descript something (about hobby, age ...)</p>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="submit-form btn btn-primary">Submit</button>
                    </div>
                </div>
            </form><!-- end form -->
            <div class="col-md-6 slide">

            </div>
        </div>
        
    <?php
        //Gắn lại các select
        if(isset($this->validItem["status"])){
            echo Helper::createScriptSelected("#status", $this->validItem["status"]);
        }
        if(isset($this->validItem["special"])){
            echo Helper::createScriptSelected("#special", $this->validItem["special"]);
        }
        if(isset($this->validItem["category_id"])){
            echo Helper::createScriptSelected("#category_id", $this->validItem["category_id"]);
        }
    ?>
    <script type="text/javascript">
        var isEdit = getUrlVar("id");
        if(isEdit <= 0){
            $("button.submit-form, a.submit-form").addClass("disabled");
            isEdit = 0;
        }
        window.onload = function(){
            $("button.submit-form, a.submit-form").click(function(e){
                var lBookname       = $("#book_name").val().length;
                var lOrdering       = $("#ordering").val().length;
                var lPrice          = $("#price").val().length;
                var sOrdering       = $("#ordering").val();
                var sStatus         = $("#status").find(":selected").val();
                var sCategory_id    = $("#category_id").find(":selected").val();
                if(lBookname == 0 || lOrdering == 0 || lPrice == 0 || (sStatus != 0 && sStatus != 1) || sOrdering < 1 || sOrdering > 20 || sCategory_id == "default"){
                    var animationCallout = $(".callout").slideDown().promise();
                    animationCallout.done(function(){
                        $(".callout").delay(5000).slideUp();
                    })
                    event.preventDefault();
                }else{
                    $("#adminForm").submit();
                }
            })
            const minLength              = 2;
            const maxLength              = 100;
            const colCheckBookname       = "name";
            checkInputStringDanger("#book_name", "Book name", [minLength,maxLength]);
            checkInputNumberDanger("#ordering", "Ordering", [1,20]);
            
            ajaxCheckInputUser("#book_name", [minLength,maxLength], '<?php echo $linkCheckBookName ?>', colCheckBookname, isEdit);
            //
            $("div.alert").delay(5000).slideUp();
        }
    </script>

    <script type="text/javascript" src="/LiarsStore/libs/extends/Ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('descript_book', {
            customConfig 	: 'config.js'
    	});
    </script>
    </section>
</aside>