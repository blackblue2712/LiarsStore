<aside class="right-side">
<?php
    $group_name     = (isset($this->validItem["name"]) ? $this->validItem["name"] : "");
    $group_name     = isset($this->validItem["group_name"]) ? $this->validItem["group_name"] : $group_name;

    $group_ordering = isset($this->validItem["ordering"]) ? $this->validItem["ordering"] : "";
    $group_descript = isset($this->validItem["group_descript"]) ? $this->validItem["group_descript"] : "";
    $group_descript = isset($_POST["form"]["group_descript"]) ? $_POST["form"]["group_descript"] : $group_descript;
    
    //url
    $url_back       = URL::createURL("admin", "group", "index");

    //linkAjax check form
    $linkCheckGroupName = URL::createURL("admin", "group", "ajaxCheckForm", array("table" => "group"));

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
                        <!-- GROUP NAME -->
                        <div class="form-group">
                            <label for="name" class="require">Group name</label>
                            <input type="text" class="form-control" id="group_name" name="form[name]" placeholder="Enter group name" value="<?php echo $group_name ?>">
                            <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                            <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                        </div>
                        <!-- GROUP ACP -->
                        <div class="form-group">
                            <label style="display:block" for="group_acp" class="require">Group acp</label>
                            <select name="form[group_acp]" id="group_acp">
                                <option value="default">--Select ACP--</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <!-- GROUP STATUS -->
                        <div class="form-group">
                            <label style="display:block" for="status" class="require">Status</label>
                            <select name="form[status]" id="status">
                                <option value="default">--Select Status--</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <!-- GROUP ORDERING -->
                        <div class="form-group">
                            <label for="ordering" class="require">Ordering</label>
                            <input type="number" class="form-control" id="ordering" name="form[ordering]" placeholder="Enter ordering number" value="<?php echo  $group_ordering ?>">
                        </div>
                        <!-- GROUP DESCRIPT -->
                        <div class="form-group">
                            <label>Textarea</label>
                            <textarea name="form[group_descript]" class="form-control" rows="3" placeholder="Enter ..."><?php echo $group_descript ?></textarea>
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
                
                <!-- <?php //include 'C:\Users\admin\Desktop\backup\training\Tu-hoc\my_design\05\01.html' ?> -->
                <!-- <img class="slide" src="<?php echo URL_IMAGE_PUBLIC ?> /13.jpg" style="margin-left: 6px; position:fixed;"> -->
            </div>
        </div>
        
    <?php
        //Gắn lại các select
        if(isset($this->validItem["status"])){
            echo Helper::createScriptSelected("#status", $this->validItem["status"]);
        }
        if(isset($this->validItem["group_acp"])){
            echo Helper::createScriptSelected("#group_acp", $this->validItem["group_acp"]);
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
                var lGroup_name = $("#group_name").val().length;
                var lOrdering   = $("#ordering").val().length;
                var sStatus     = $("#status").find(":selected").val();
                var sGroup_acp  = $("#group_acp").find(":selected").val();
                if(lGroup_name == 0 || lOrdering == 0 || (sStatus != 0 && sStatus != 1) || (sGroup_acp != 0 && sGroup_acp != 1)){
                    var animationCallout = $(".callout").slideDown().promise();
                    animationCallout.done(function(){
                        $(".callout").delay(5000).slideUp();
                    })
                    event.preventDefault();
                }else{
                    $("a.submit-form").submit();
                }
            })
            checkInputStringDanger("#group_name", "Group name", [2,10]);
            checkInputNumberDanger("#ordering", "Ordering", [1,20]);

            ajaxCheckInputUser("#group_name", [2,10], '<?php echo $linkCheckGroupName ?>', isEdit);


            //
            $("div.alert").delay(5000).slideUp();
            //
        
        //     var heightForm = $("#adminForm").height();
        //     $("img.slide").css("height", heightForm);

        //     for(i = 0; i < heightForm; i++){
        //         var x = i + 213;
        //         $("div.slide").append('<div style="top:'+x+'px" class="mark"></div>');
        //     }

        //     function removeMark(){
        //         var elementHide = $("div.mark");

        //         $(shuffle(elementHide)[0]).remove();
        //         var p = setTimeout(removeMark, 50);
        //         if(elementHide.length == 0){
        //             clearTimeout(p);
        //             crateHide();
        //         }
        //     }
        //     i = 1;
	    //     y = heightForm;
        //     function crateHide(){
        //         $("div.slide").append('<div style="top:'+(i+213)+'px;" class="mark"></div>');
        //         $("div.slide").append('<div style="top:'+(y+213)+'px;" class="mark"></div>');
        //         // delete rand[shuffle(rand)[0]];
        //         var p = setTimeout(crateHide, 50);
        //         if(i >= heightForm/2){
        //             clearTimeout(p);
        //             i = 1;
        //             y = heightForm;
        //             // $(".image").empty();
        //             // $(".image").html("<img src="+shuffle(randImg)[0]+">");
        //             removeMark();
        //         }
        //         i++;
        //         y--;
        //     }

        //     removeMark();
        }
        
    </script>
    </section>
</aside>