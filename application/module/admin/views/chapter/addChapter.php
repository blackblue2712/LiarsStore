<aside class="right-side">
<?php
    $url_back = URL::createURL("admin", "book", "index");
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
            <li class="active">Add chapter</li>
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
                <div class="col-md-12">
                    <!-- DESCRIPT -->
                    <div class="form-group">
                        <label>Content</label>
                        <textarea id="descript_book" name="form[book_descript]" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                        <p class="help-block">Add a new chapter ()</p>
                    </div>
                </div>
                <div  class="col-md-6">
                    <div class="box-body">
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
                            <input type="number" class="form-control" id="ordering" name="form[ordering]" placeholder="Enter ordering number" value="">
                        </div>
                        <!-- CHAPTER NUMBER -->
                        <div class="form-group">
                            <label for="ordering" class="require">Chapter</label>
                            <input type="number" class="form-control" id="chapter" name="form[chapter]" placeholder="Enter chapter number" value="">
                        </div>
                        <input type="hidden" name="token" value="<?php echo time() ?>">
                        <button type="submit" class="submit-form btn btn-primary">Submit</button>
                    </div><!-- /.box-body -->
                </div><!-- md 6 -->
            </form><!-- end form -->
            <div class="col-md-6 slide">

            </div>
        </div>
        
    <?php
        //Gắn lại các select
       
    ?>
    <script type="text/javascript">
        
        window.onload = function(){
            // $("button.submit-form, a.submit-form").click(function(e){
            //     var lDes            = $("#descript_book").val().length;
            //     var lOrdering       = $("#ordering").val().length;
            //     var sOrdering       = $("#ordering").val();
            //     var sStatus         = $("#status").find(":selected").val();
            //     var lChapter        = $("#chapter").val().length;
            //     if(lDes == 0 || lOrdering == 0 || (sStatus != 0 && sStatus != 1) || sOrdering < 1 || sOrdering > 20 || lChapter == 0){
            //         var animationCallout = $(".callout").slideDown().promise();
            //         animationCallout.done(function(){
            //             $(".callout").delay(5000).slideUp();
            //         })
            //         event.preventDefault();
            //     }else{
            //         $("#adminForm").submit();
            //     }
            // })
            
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