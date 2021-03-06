<?php
    $urlCheckPassword  = URL::createURL("admin", "lock-screen", "checkPassword");
    $urlLoginDiffernce = URL::createURL("admin", "lock-screen", "logout");
    $infoUser = $_SESSION["userLogin"]["infoUser"];

    $fullName = $infoUser["fullname"];
    $email    = $infoUser["email"];
    $picture    = Helper::createPathPicture(PATH_PICTURE_USER, URL_PICTURE_USER, "maxResize", $infoUser["avatar"]);
    

?>
<!DOCTYPE html>
<html class="loading">
    <head>
        <meta charset="UTF-8">
        <title>Liars | Lockscreen</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo $this->_fileCss ?>
        <style type="text/css">
            .lockscreen{
                background: url("application/module/admin/views/lock-screen/background/2.jpg");
                /* opacity: 0.9; */
            }
            .loading{
                background: url("public/loading/loading.gif") center center no-repeat;
            }
            .mark{
                opacity: 0.6;
                display: none;
                position: fixed;
                z-index: 1000;
                width: 100%;
                height: 100%;
            }
            .layer{
                width: 100%;
                background: #333333;
                opacity: 0.3;
                position: fixed;
                z-index: 1;
            }
            .lockscreen-name{
                font-size: 72px;
                background: -webkit-linear-gradient(#eee, #040c74);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            #time{
                background: -webkit-linear-gradient(#eee, #9b1414);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .label{
                margin-top: 6px;
                display: inline-block;
                font-size: 15px;
            }
        </style>
    </head>
    <body class="lockscreen">
        <div class="loading mark"></div>
        <div class="layer" style="display:none;"></div>
        <!-- Automatic element centering using js -->
        <div class="center">            
            <div class="headline text-center" id="time">
                <!-- Time auto generated by js -->
            </div><!-- /.headline -->
            
            <!-- User name -->
            <div class="lockscreen-name"><?php echo $fullName ?></div>
            
            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="<?php echo $picture ?>" alt=""/>
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <div class="lockscreen-credentials">   

                    <div class="input-group">
                        <form action="#" method="POST" name="adminForm" ></form>
                            <input type="password" class="form-control" placeholder="password" />
                        </form>
                        <div class="input-group-btn">
                            <button class="btn btn-flat"><i class="fa fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                </div><!-- /.lockscreen credentials -->

            </div><!-- /.lockscreen-item -->

            <div class="lockscreen-link">
                <a href="<?php echo $urlLoginDiffernce ?>">Or sign in as a different user</a>
            </div>            
        </div><!-- /.center -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                startTime();
                $(".center").center();
                $(window).resize(function() {
                    $(".center").center();
                });
            });

            /*  */
            function startTime()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);

                //Check for PM and AM
                var day_or_night = (h > 11) ? "PM" : "AM";

                //Convert to 12 hours system
                if (h > 12)
                    h -= 12;

                //Add time to the headline and update every 500 milliseconds
                $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
               
                setTimeout(function() {
                    startTime()
                }, 500);
            }

            function checkTime(i)
            {
                if (i < 10)
                {
                    i = "0" + i;
                }
                return i;
            }

            /* CENTER ELEMENTS IN THE SCREEN */
            jQuery.fn.center = function() {
                this.css("position", "absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                        $(window).scrollTop()) - 30 + "px");
                this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                        $(window).scrollLeft()) - 400 + "px");
                return this;
            }

            var i = 1;
               
            
           
            function scrollYUp(){
                $(".lockscreen").css("background-position-y", "-" + i + "px");
                i+=10;
                if(i < 260){
                    p = setTimeout(scrollYUp, 1);
                }else{
                    clearTimeout(p);
                    scrollYDown();
                }
            }
            function scrollYDown(){
                i--;
                $(".lockscreen").css("background-position-y", "-" + i + "px");
                if(i > 0){
                    p = setTimeout(scrollYDown, 1);
                }else{
                    clearTimeout(p);
                }
            }
            scrollYUp();
        </script>


            <!-- CUSTOM -->
        <script type="text/javascript">
            $("body").css("height", $("html").height() + "px" );
            $(".mark, .layer").css("height", $("html").height() + "px" );


            $(document).ready(function(){
                $("body").on({
                    keyup   : function(){
                        var password = $(this).val();
                        
                        if( password.trim().length >= 6 ){
                            var ajaxCheckPassword = '<?php echo $urlCheckPassword ?>';
                            $.ajax({
                                url     : ajaxCheckPassword,
                                type    : "POST",
                                dataType: "json",
                                data    : {"password" : password.trim()}
                            }).done(function(data){
                                if(data.status == 1){
                                    $("input[type=password]").css("display", "none");
                                    $(".mark").fadeIn();
                                    $(".layer").css("display", "block");
                                    $("form[name=adminForm]").append("<label class='label label-success'>Wait for Redirecting ...</label>");
                                    var animation = $(".lockscreen").show().delay(2000).promise();
                                    animation.done(function(){
                                        window.location = data.redirect;
                                    })
                                }
                            })
                        }
                    },
                }, 'input[type=password]');
            })
        </script>
    </body>
</html>