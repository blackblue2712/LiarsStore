<aside class="right-side">
<?php
    $category_name     = (isset($this->validItem["name"]) ? $this->validItem["name"] : "");
    $category_name     = isset($this->validItem["category_name"]) ? $this->validItem["category_name"] : $category_name;

    $fullname      = isset($this->validItem["fullname"]) ? $this->validItem["fullname"] : "";
    $fullname      = isset($_POST["form"]["fullname"]) ? $_POST["form"]["fullname"] : $fullname;


    $category_ordering = isset($this->validItem["ordering"]) ? $this->validItem["ordering"] : "";
    $category_descript = isset($this->validItem["category_descript"]) ? $this->validItem["category_descript"] : "";
    $category_descript = isset($_POST["form"]["category_descript"]) ? $_POST["form"]["category_descript"] : $category_descript;

    $picture = isset($this->defaultItem["picture"]) ? URL_PICTURE_CATEGORY.DS."60x90-".$this->defaultItem["picture"] : "";
    if($picture != ""){
        echo Helper::createScript("$('img#preview_picture').show().css('display','block')");
    }
    
    //url
    $url_back       = URL::createURL("admin", "category", "index");

    //linkAjax check form
    $linkCheckCategoryName = URL::createURL("admin", "category", "ajaxCheckForm", array("table" => "category"));

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
            <div  class="col-md-6">
                <form id="adminForm" name="adminForm" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <!-- categoryNAME -->
                        <div class="form-group">
                            <label for="name" class="require">Category name</label>
                            <input type="text" class="form-control" id="category_name" name="form[name]" placeholder="Enter category name" value="<?php echo $category_name ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        
                        <!-- Full name -->
                        <div class="form-group has-feedback">
                            <label style="display:block" for="name" class="avatar">Picture</label>
                            <input style="display:none" type="file" class="avatar" id="picture" name="picture" placeholder="Enter fullname" value="<?php echo $fullname ?>">
                            <a href="javascript:openFile()" class="choose_avatar"><i style="font-size: 100px; color: #ccc" class="fa fa-picture-o"></i></a>
                            <img src="<?php echo $picture ?>" id="preview_picture" style="display: none">
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
                        <!-- ORDERING -->
                        <div class="form-group">
                            <label for="ordering" class="require">Ordering</label>
                            <input type="number" class="form-control" id="ordering" name="form[ordering]" placeholder="Enter ordering number" value="<?php echo  $category_ordering ?>">
                        </div>
                        <!-- DESCRIPT -->
                        <div class="form-group">
                            <label>Descript</label>
                            <textarea name="form[category_descript]" class="form-control" rows="3" placeholder="Enter ..."><?php echo $category_descript ?></textarea>
                            <p class="help-block">Descript something (about hobby, age ...)</p>
                        </div>
                        <input type="hidden" name="token" value="<?php echo time() ?>">
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="submit-form btn btn-primary">Submit</button>
                    </div>
                </form><!-- end form -->
            </div><!-- md 6 -->
            <div class="col-md-6 slide">

            </div>
        </div>
        
    <?php
        //Gắn lại các select
        if(isset($this->validItem["status"])){
            echo Helper::createScriptSelected("#status", $this->validItem["status"]);
        }
        if(isset($this->validItem["group_id"])){
            echo Helper::createScriptSelected("#group_id", $this->validItem["group_id"]);
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
                var lCategoryname   = $("#category_name").val().length;
                var lOrdering   = $("#ordering").val().length;
                var sOrdering   = $("#ordering").val();
                var sStatus     = $("#status").find(":selected").val();
                var sGroup_acp  = $("#group_acp").find(":selected").val();
                if(lCategoryname == 0 || lOrdering == 0 || (sStatus != 0 && sStatus != 1) || sOrdering < 1 || sOrdering > 20 ){
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
            const colCheckCategoryname   = "name";
            checkInputStringDanger("#category_name", "Category name", [minLength,maxLength]);
            checkInputNumberDanger("#ordering", "Ordering", [1,20]);
            
            ajaxCheckInputUser("#category_name", [minLength,maxLength], '<?php echo $linkCheckCategoryName ?>', colCheckCategoryname, isEdit);


            //
            $("div.alert").delay(5000).slideUp();
        }
        
        // test
        // window.onload = function(){
        //     $("button.submit-form, a.submit-form").click(function(e){
        //         $("#adminForm").submit();
        //     } );  
            
        // }

        function openFile(){
            $("input.avatar").click();
            $("img#preview_picture").hide();
            return false;
        }
        let checkFile = true;

        $('input.avatar').on('change',function(){
            var filename = this.value.split('\\').pop();
            $('label.avatar').text( "Picture: " + filename );
            $("a.choose_avatar i").removeClass("fa fa-picture-o");
            
            var animation = $("a.choose_avatar i").css({
                "background" : "url(public/loading/Ball-0.7s-100px.gif) center center",
                "display"    : "inline-block",
                "width"      : "100px",
                "height"     : "100px",
            }).show().delay(1000).promise();

            checkFileUpload =  previewPicture(this);
            console.log(checkFileUpload.fileSize)
            if(checkFileUpload.fileSize == 0){
                checkFile = true;
                $("label.avatar i").remove();
                $("label.avatar").closest("div.form-group").removeClass("has-warning").removeClass("has-success");
                $("img#preview_picture").hide();
                $("a.choose_avatar i").css("background","none").addClass("fa fa-picture-o");
            }else if(checkFileUpload.fileSize < SIZE_UPLOAD.min || checkFileUpload.fileSize > SIZE_UPLOAD.max || (EXTENDSION_UPLOAD.indexOf(checkFileUpload.fileExtension) < 0 ) ){
                checkFile = false;
                $("label.avatar i").remove();
                $("label.avatar").prepend('<i class="fa fa-warning"></i>').closest("div.form-group").addClass("has-warning").removeClass("has-success");
                $("img#preview_picture").hide();
                $("a.choose_avatar i").css("background","none").addClass("fa fa-picture-o");
            }else{
                checkFile = true;
                animation.done(function(){
                    $("label.avatar i").remove();
                    $("label.avatar").prepend('<i class="fa fa-success"></i>').closest("div.form-group").addClass("has-success").removeClass("has-warning");
                    $("img#preview_picture").show();
                    $("a.choose_avatar i").css("background","none").addClass("fa fa-picture-o");
                    $("a.choose_avatar").css("display", "block");
                })
            }

            if(checkFile == false){
                $("button.submit-form, a.submit-form").addClass("disabled");
            }else{
                $("button.submit-form, a.submit-form").removeClass("disabled");
            }
        })//Change function
        

    </script>
    </section>
</aside>