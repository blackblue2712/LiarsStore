
<?php
    $username = isset($this->params["form"]["username"]) ? $this->params["form"]["username"] : "";
    $msg      = isset($_SESSION["msg"]) ? Session::get("msg") : "";
    Session::delete("msg");
?>

<div class="form-box" id="login-box">
    <div style="display: block; color: #076b49">
        <div class="">
            <div class="modal-content" style="background-color: #1C1C1C">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: darkgreen">Sign in</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                    <form action="/LiarsStore/index.php?module=admin&amp;controller=index&amp;action=login" method="post" id="loginForm">
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
        </div>
    