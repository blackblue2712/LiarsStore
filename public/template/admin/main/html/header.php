<?php
    $infoUser = $_SESSION["userLogin"]["infoUser"];
    $fullName = $infoUser["fullname"];
    $email    = $infoUser["email"];
    
    $linkLockScreen = URL::createURL("admin", "lock-screen", "index");
    $url_bookstore  = URL::createURL("client", "index", "index");
    $url_cart       = URL::createURL("admin", "cart-book", "index");
    $picture    = Helper::createPathPicture(PATH_PICTURE_USER, URL_PICTURE_USER, "maxResize", $_SESSION["userLogin"]["infoUser"]["avatar"]);

    //GET NOTIFICATIONS
    include_once PATH_LIBS . DS . "Model.php";
    $model = new Model();
    $querySelectNotifi = "SELECT * FROM notifications WHERE `status` > 0";
    $listNotfi = $model->fetchAll($querySelectNotifi);
    
    $strCNotifi = 'You don\'t have any notification';
    $badgeNotifi= "";
    $strNotifi = "";
    $isSeen    = 0;
    if(isset($listNotfi)){
        foreach($listNotfi as $key => $value){
            $strNotifi .= '<i class="ion ion-ios7-cart success"></i> '.$value["status"].' sales made';
            if($value["is_seen"] == 0) $isSeen += 1;
        }
        if($isSeen > 0){
            $strCNotifi = 'You have '.$isSeen.' notifications';
            $badgeNotifi= '<span class="label label-danger">'.$isSeen.'</span>';
        }
    }

    $url_dashboard  = URL::createURL("admin", "index", "index");
?>

<header class="header">
            <a href="<?php echo $url_dashboard ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Liars Store
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle count-notifications" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-globe"></i>
                                <?php echo $badgeNotifi ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo $strCNotifi ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li class="count-sales-made">
                                            <a href="<?php echo $url_cart?>">
                                                <?php echo $strNotifi?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $fullName ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo $picture ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $fullName ?> - Web Developer
                                        <small>Member since Nov. 2017</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer text-center">
                                    <div class="col-md-4">
                                        <a href="javascript:viewSite('<?php echo $url_bookstore ?>')" class="btn btn-default" title="View-Site"><span class="fa fa-share-square-o"></span></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?php echo $linkLockScreen?>" class="btn btn-default" title="Lock Screen"><span class="fa fa-windows"></span></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a id="logout" href="#" class="btn btn-default" title="Sign out"><span class="fa fa-sign-out"></span></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        