<?php
    $keyword = "";
    if(isset($this->params["form"]["keyword"])){
        $keyword = $this->params["form"]["keyword"];
    }

    //cart
    $badge_cart = 0;
    $amounts = 0;
    if(isset($_SESSION["userLogin"]["totalItemInCart"])){
        $badge_cart = $_SESSION["userLogin"]["totalItemInCart"];
        $amounts    = $_SESSION["userLogin"]["totalAmount"];
    }

    $username = "";
    $xHeader  = "";
    $urlMyAccount   = URL::createURL("client", "user", "index", null,"/account.html");
    $urlLogin       = URL::createURL("client", "index", "login", null,"/login.html");
    $urlDetailCart  = URL::createURL("client", "cart-book", "detail", null,"/cart.html");
    $urlHistoryCart = URL::createURL("client", "cart-book", "history", null,"/history.html");
    $urlSearch      = URL::createURL("client", "cart-book", "history", null,"/index.html");
    
    if(isset($_SESSION["userLogin"])){
        $cPanel = "";
        if($_SESSION["userLogin"]["infoUser"]["group_acp"] == 1){
            $urlDerectAdmin = URL::createURL("admin", "index", "index");
            $cPanel = '<li><a class="fxlink-admin" href="javascript:viewSite(\''.$urlDerectAdmin.'\')">Direct Admin</a></li>';
        }
        $username = (strlen($_SESSION["userLogin"]["infoUser"]["fullname"]) != 0) ? $_SESSION["userLogin"]["infoUser"]["fullname"] : $_SESSION["userLogin"]["infoUser"]["username"];
        $xHeader .= '<div class="btn-group ">
                        <button type="button" class="btn btn btn-bdown username btn-small" style="font-weight: bold;">Hello, '.$username.'</button>
                        <button type="button" class="btn btn btn-bdown dropdown-toggle btn-small" data-toggle="dropdown"><span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="'.$urlMyAccount.'">My Account</a></li>
                            <li><a class="fxlink-logout" href="javascript:void(0)">Sign out</a></li>
                            <li class="divider"></li>'.$cPanel.'
                        </ul>
                    </div>
                    <a class="my-cart main-wrap-cart" href="javascript:onOpenCart()" type="button" class="btn btn-red btn-small">
                        <span class="fa fa-shopping-cart">
                            <small style="background: #f56954; position:absolute; top:0px;right:0px" class="badge badge-cart pull-right bg-red">'.$badge_cart.'</small>
                        </span>
                    </a>
                    <div class="my-cart layer_hide">
                        <span class="alert alert-success cart-amount"><i class="fa fa-dollar"></i> '.number_format($amounts).'</span>
                        <span class="alert alert-success cart-detail">
                            <a href="'.$urlDetailCart.'"> <i class="fa fa-pencil"></i> Details </a>
                        </span>
                        <span class="alert alert-success cart-history">
                            <a href="'.$urlHistoryCart.'"> <i class="fa fa-chevron-left"></i> History </a>
                        </span>
                        </div>';
    }else{
        $xHeader .= '<a class="button-register" rel="nofollow" href="#"></a>
                    <a class="button-login" rel="nofollow" href="'.$urlLogin.'"></a>
                    <a class="button-login-with-fb" rel="nofollow" href="#"></a>';
    }
    
?>
<div class="header">
    <div class="container">
        <div class="header-logo"><a class="logo" href="#"><span>ANIME47.COM</span></a></div>
        <div class="widget_search">
            <form method="POST" id="form-search" name="form-search" action="<?php echo $urlSearch?>">
                <div>
                    <input type="text" name="form[keyword]" placeholder="Find: name, author, description" value="<?php echo $keyword?>" onkeyup="onSearch(this.value)" id="searchkeyword" autocomplete="off">
                    <input id="searchsubmit" class="" value=" " type="submit">
                </div>
            </form>
            <div class="search-suggest" style="display: none;">
                <ul style="margin-bottom: 0;" id="search-suggest-list">
                    
                </ul>
            </div>
        </div>
        <div class="widget_user_header">
            <?php echo $xHeader ?>
        </div>
    </div>
</div>
<div class="clear"></div>