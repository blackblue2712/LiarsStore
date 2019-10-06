<aside class="right-side">
<?php
    $user_name     = (isset($this->validItem["username"]) ? $this->validItem["username"] : "");
    $user_name     = isset($this->validItem["user_name"]) ? $this->validItem["user_name"] : $user_name;

    $email         = isset($this->validItem["email"]) ? $this->validItem["email"] : "";

    $fullname      = isset($this->validItem["fullname"]) ? $this->validItem["fullname"] : "";
    $fullname      = isset($_POST["form"]["fullname"]) ? $_POST["form"]["fullname"] : $fullname;


    $user_ordering = isset($this->validItem["ordering"]) ? $this->validItem["ordering"] : "";
    $user_descript = isset($this->validItem["user_descript"]) ? $this->validItem["user_descript"] : "";
    $user_descript = isset($_POST["form"]["user_descript"]) ? $_POST["form"]["user_descript"] : $user_descript;
    
    //url
    $url_back       = URL::createURL("admin", "user", "index");

    //linkAjax check form
    $linkCheckUserName = URL::createURL("admin", "user", "ajaxCheckForm", array("table" => "user"));
    $linkCheckEmail    = URL::createURL("admin", "user", "ajaxCheckForm", array("table" => "user"));

    $picture = isset($this->defaultItem["picture"]) ? URL_PICTURE_USER.DS."maxResize".$this->defaultItem["picture"] : "";
    if($picture != ""){
        echo Helper::createScript("$('img#preview_picture').show().css('display','block')");
    }

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
                        <!-- USERNAME -->
                        <div class="form-group">
                            <label for="name" class="require">User name</label>
                            <input type="text" class="form-control" id="user_name" name="form[username]" placeholder="Enter user name" value="<?php echo $user_name ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        <!-- PICTURE -->
                        <div class="form-group has-feedback">
                            <label style="display:block" for="avatar" class="avatar">Picture</label>
                            <input style="display:none" type="file" class="avatar" id="picture" name="picture" placeholder="Enter fullname" value="<?php echo $fullname ?>">
                            <a href="javascript:openFile()" class="choose_avatar"><i style="font-size: 100px; color: #ccc" class="fa fa-picture-o"></i></a>
                            <img src="<?php echo $picture ?>" id="preview_picture" style="display: none">
                        </div>
                        <!-- EMAIL -->
                        <div class="form-group">
                            <label for="name" class="require">Email</label>
                            <input type="email" class="form-control" id="email" name="form[email]" placeholder="Enter email" value="<?php echo $email ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        <!-- Full name -->
                        <div class="form-group">
                            <label for="name" class="">Full name</label>
                            <input type="text" class="form-control" id="fullname" name="form[fullname]" placeholder="Enter fullname" value="<?php echo $fullname ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        <!-- GROUP NAME -->
                        <?php
                            $xhtmlG = '';
                            foreach($this->_listGroup as $key => $value){
                                $xhtmlG .= '<option name="'.$value["name"].'" value="'.$value["id"].'">'.$value["name"].'</option>';
                            }
                        ?>
                        <div class="form-group">
                            <label style="display:block" for="group_id" class="require">Group id</label>
                            <select name="form[group_id]" id="group_id">
                                <option value="default">-Select Group-</option>
                                <?php echo $xhtmlG?>
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
                        <!-- ORDERING -->
                        <div class="form-group">
                            <label for="ordering" class="require">Ordering</label>
                            <input type="number" class="form-control" id="ordering" name="form[ordering]" placeholder="Enter ordering number" value="<?php echo  $user_ordering ?>">
                        </div>
                        <!-- DESCRIPT -->
                        <div class="form-group">
                            <label>Descript</label>
                            <textarea name="form[user_descript]" class="form-control" rows="3" placeholder="Enter ..."><?php echo $user_descript ?></textarea>
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
                var lUsername   = $("#user_name").val().length;
                var lOrdering   = $("#ordering").val().length;
                var sOrdering   = $("#ordering").val();
                var sStatus     = $("#status").find(":selected").val();
                var sGroup_acp  = $("#group_acp").find(":selected").val();
                if(lUsername == 0 || lOrdering == 0 || (sStatus != 0 && sStatus != 1) || sOrdering < 1 || sOrdering > 20 ){
                    var animationCallout = $(".callout").slideDown().promise();
                    animationCallout.done(function(){
                        $(".callout").delay(5000).slideUp();
                    })
                    event.preventDefault();
                }else{
                    $("#adminForm").submit();
                }
            })
            const minLength          = 2;
            const maxLength          = 20;
            const colCheckUsername   = "username";
            const colCheckEmail      = "email";
            checkInputStringDanger("#user_name", "User name", [minLength,maxLength]);
            checkInputNumberDanger("#ordering", "Ordering", [1,20]);
            ajaxCheckInputUser("#user_name", [minLength,maxLength], '<?php echo $linkCheckUserName ?>', colCheckUsername, isEdit);
            ajaxCheckInputUser("#email", [minLength,100], '<?php echo $linkCheckEmail ?>', colCheckEmail, isEdit);


            //
            $("div.alert").delay(5000).slideUp();
        }
    </script>
    </section>
</aside>