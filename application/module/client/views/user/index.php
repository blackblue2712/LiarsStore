
<?php
    
    $username = $_SESSION["userLogin"]["infoUser"]["username"];
    $fullname = $_SESSION["userLogin"]["infoUser"]["fullname"];
    $email    = $_SESSION["userLogin"]["infoUser"]["email"];
    $avatar   = $_SESSION["userLogin"]["infoUser"]["avatar"];

    $avatar         = Helper::createPathPicture(PATH_PICTURE_USER, URL_PICTURE_USER, "maxResize", $avatar);
    $urlChangeAvatar= URL::createURL("client", "user", "changeAvatar");
   
?>
<div class="wrap-info-avatar" style="">
    <img class="info-avatar" id="preview_picture" src="<?php echo $avatar?>" alt="">
    <div>
        <a href="javascript:openFile()" class="edit-avatar"><i class="fa fa-camera"></i></a>
        <form action="<?php echo $urlChangeAvatar ?>" method="post" enctype="multipart/form-data" name="form-change-avatar" id="form-change-avatar">
            <input type="file" class="avatar" style="display:none" name="avatar">
            <a class="btn btn-default btn-savechange-avatar">Save</a>
        </form>
    </div>
</div>
<div class="col-sm-8" style="margin-top: 76px;">
    <div class="mark-animation"></div>
    <div class="form-box" id="login-box">
        <div style="display: block; color: #076b49">
            <div class="modal-info-user">
                <div class="modal-content" style="background-color: #1C1C1C;">
                    <div class="modal-header">
                        <h4 class="modal-title" style="color: darkgreen"><samp><?php echo $username ?><samp></h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="PSOT" name="info_user_form" id="info_user_form">
                            <div class="block ">
                                <div class="col-sm-3 text-left">
                                    Name
                                </div>
                                <div class="col-sm-7 text-left show-fullname">
                                    <?php echo $fullname ?>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" class="change-fullname"><i class="fa fa-pencil"></i></a>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 box-change-fullname" style="padding: 30px 0px">
                                    <label for="fullname">Name: </label>
                                    <input type="text" name="form[fullname]" value="<?php echo $fullname ?>" class="form-control" id="fullname">
                                    <a id="closeBox" href="javascript:void(0)" class="btn btn-sm btn-default">Close</a>
                                    <a id="" href="javascript:changeInfo('#fullname')" class="btn btn-sm btn-default">Save</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="block">
                                <div class="col-sm-3 text-left">
                                    Email
                                </div>
                                <div class="col-sm-7 text-left show-email">
                                    <?php echo $email ?>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" class="changeEmail"><i class="fa fa-pencil"></i></a>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 box-change-email" style="padding: 30px 0px">
                                    <label for="email">Email: </label>
                                    <input type="text" name="form[email]" value="<?php echo $email ?>" class="form-control" id="email">
                                    <a id="closeBox" href="javascript:void(0)" class="btn btn-sm btn-default">Close</a>
                                    <a id="" href="javascript:changeInfo('#email')" class="btn btn-sm btn-default">Save</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="block">
                                <div class="col-sm-3 text-left">
                                    Password
                                </div>
                                <div class="col-sm-7 text-left show-password-hide">
                                    
                                </div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" class="changePassword"><i class="fa fa-pencil"></i></a>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 box-change-password" style="padding: 30px 0px">
                                    <label for="email">New Password: </label>
                                    <input type="password"  value="" class="form-control" id="new-password">
                                    <label for="email">Old Password: </label>
                                    <input type="password"  value="" class="form-control" id="old-password">
                                    <a id="closeBox" href="javascript:void(0)" class="btn btn-sm btn-default">Close</a>
                                    <a id="" href="javascript:changePassword('#new-password', '#old-password')" class="btn btn-sm btn-default">Save</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                        <div class="margin text-center">
                            <span style="margin-bottom: 4px; display:inline-block">Sign in using social networks</span>
                            <br/>
                            
                        </div>
                    </div> -->
                </div>
            </div><!--  end modal login -->
        </div>
    </div>
</div>

