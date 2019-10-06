var formLogin = '<form action="#" method="post" name="login_ajax_form" >'
                    +'<div class="body bg-gray">'
                        +'<div class="form-group">'
                            +'<input type="text" name="form[username]" class="form-control username" placeholder="User ID" value=""/>'
                        +'</div>'
                        +'<div class="form-group">'
                            +'<input type="password" name="form[password]" class="form-control password" placeholder="Password"/>'
                        +'</div>'
                        
                        +'<div class="msg"></div> '
                    +'</div>'
                    +'<div class="footer">                                                               '
                        +'<a href="javascript:ajaxCheckPassword()" class="btn btn-block login-ajax btn-login">Sign me in</a>'
                        +'<p><a href="#">I forgot my password</a></p>'
                        +'<a href="register.html" class="text-center">Register a new membership</a>'
                        +'<input type="hidden" name="form[token]" class="token" value="'+Date.now()+'">'
                    +'</div>'
                        +'<div class="margin text-center">'
                        +'<span>Sign in using social networks</span>'
                        +'<br/>'
                        +'<button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>'
                        +'<button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>'
                        +'<button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>'
                    +'</div>'
                +'</form>';

const SIZE_UPLOAD        = {min: 1000, max: 5242880};
const EXTENDSION_UPLOAD  = ["jpg", "png", "gif"];