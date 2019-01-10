
<?php
    
    $username = isset($this->params["form"]["username"]) ? $this->params["form"]["username"] : "";
    $msg      = isset($_SESSION["msg"]) ? Session::get("msg") : "";
    Session::delete("msg");

    $linkCheckUserName = URL::createURL("client", "index", "ajaxCheckForm", array("table" => "user"));
    $linkCheckEmail    = URL::createURL("client", "index", "ajaxCheckForm", array("table" => "email"));
    $linkRegister      = URL::createURL("client", "index", "register");
    $notice_msg = "";
    if(isset($_SESSION['notice'])){
        $notice_msg = "<span class='alert alert-danger notice' style='display:none'>".$_SESSION['notice']."</span>";
        unset($_SESSION["notice"]);
    }
    
?>
<div class="col-sm-8" style="margin-top: 20px">
    <?php echo $notice_msg;?>
    <div class="form-box" id="login-box">
        <div style="display: block; color: #076b49">
            <div class="">
                <div class="modal-content" style="background-color: #1C1C1C">
                    <div class="modal-header">
                        <h4 class="modal-title" style="color: darkgreen">Sign in</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                        <form action="/LiarsStore/index.php?module=client&amp;controller=index&amp;action=login" method="post" id="loginForm">
                        <div class="body bg-gray">
                            <div class="form-group"><input id="login_username" type="text" name="form[username]" class="form-control" placeholder="User ID" value=""></div>
                            <div class="form-group"><input id="login_password" type="password" name="form[password]" class="form-control" placeholder="Password"></div>
                            <div class="form-group"><label style="font-weight: normal"><input type="checkbox" name="remember_me"> Remember me</label></div>
                            <div class="msg">
                                <!--?php echo $msg?-->
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit" class="btn bg-olive btn-block btn-login" style="">Sign me in</button>  
                            <p style="margin-top: 10px"><a href="#">I forgot my password</a></p>
                            <a href="javascript:$('#myModal').modal('show')" class="text-center">Register a new membership</a><input type="hidden" name="form[token]" value="1545747636283">
                        </div>
                        </form>
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <div class="margin text-center">
                            <span style="margin-bottom: 4px; display:inline-block">Sign in using social networks</span>
                            <br/>
                            <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                            <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                            <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

                        </div>
                    </div>
                </div>
            </div><!--  end modal login -->
            <div id="myModal" class="modal fade modal-custom" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #1C1C1C">
                        <div class="modal-header">
                            <button style="color: whitesmoke" type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title" style="color: darkgreen">Register</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                            <form action="/LiarsStore/index.php?module=client&controller=index&action=register" method="post">
                                <div class="body bg-gray">
                                    <div class="form-group">
                                        <label for="username" class="require">User name</label>
                                        <input id="user_name" type="text" name="form[username]" class="form-control" placeholder="User ID" value="">
                                        <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                                        <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                                        <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="require">Email</label>
                                        <input id="email" type="email" name="form[email]" class="form-control" placeholder="Email">
                                        <span class="form-control-feedback loading" style="background: url(public/loading/loadingnb.gif); min-height:32px; min-width:32px; display:none"></span>
                                        <span class="form-control-feedback success" style="background: url(public/loading/success.gif); min-height:32px; min-width:32px; display:none"></span>
                                        <span class="form-control-feedback warning" style="background: url(public/loading/warning.gif); min-height:32px; min-width:32px; display:none"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="require">Password</label>
                                        <input id="password" type="password" name="form[password]" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="require">Comfirm Password</label>
                                        <input id="confirm_password" type="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname" class="">Full name</label>
                                        <input type="text" name="form[fullname]" class="form-control" placeholder="Full name">
                                    </div>
                                    <div class="msg">

                                    </div>
                                </div>
                                <div class="footer">
                                    <button type="submit" class="btn btn-block submit-form" style="">Register</button>  
                                </div>
                            </form>
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <div class="margin text-center">
                                <span style="margin-bottom: 4px; display:inline-block">Sign in using social networks</span>
                                <br/>
                                <div class="text-center">
                                    <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                                    <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                                    <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end modal register -->
            <!-- <div class="modal-backdrop"></div> -->
        </div>
    </div>
</div>

<script type="text/javascript">
        window.onload = function(){
            $(".modal-custom button[type=submit]").addClass("disabled");
            $("button.submit-form").click(function(e){
                var lUsername   = $("#user_name").val().length;
                var lemail      = $("#email").val().length;
                var lpassword   = $("#password").val().length;

                if(lUsername == 0 || lemail == 0 || lpassword == 0){
                    var animationCallout = $(".callout").slideDown().promise();
                    animationCallout.done(function(){
                        $(".callout").delay(5000).slideUp();
                    })
                    event.preventDefault();
                }else{
                    $("#adminForm").submit();
                }
            })
            
            const colCheckUsername   = "username";
            const colCheckEmail      = "email";
            const minLength          = 2;
            const maxLength          = 20;
            checkInputStringDanger("#user_name", "User name", [minLength,maxLength]);
            checkInputStringDanger("#email", "Email", [minLength,100], true);
            ajaxCheckInputUser("#user_name", [minLength,maxLength], '<?php echo $linkCheckUserName ?>', colCheckUsername);
            ajaxCheckInputUser("#email", [minLength,100], '<?php echo $linkCheckUserName ?>', colCheckEmail);

            $("#confirm_password").keyup(function(){
                console.log($(this).val())
                console.log($("#password").val())
                if( $("#confirm_password").val() != $("#password").val() && $("#password").val().length > 2){
                    $("button.submit-form").addClass("disabled");
                }else if($(this).val() == $("#password").val()){
                    $("button.submit-form").removeClass("disabled");
                }
            })

            $("span.notice").delay(100).slideDown().delay(5000).slideUp();

        }
    </script>