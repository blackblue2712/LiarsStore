<?php
  
    $url_group      = URL::createURL("admin", "group", "index");
    $url_user       = URL::createURL("admin", "user", "index");
    //dashboard declare in header
    $url_category   = URL::createURL("admin", "category", "index");
    $url_book       = URL::createURL("admin", "book", "index");
    $url_cart_book  = URL::createURL("admin", "cart-book", "index");
    $url_chapter    = URL::createURL("admin", "chapter", "index");


    $url_analytics_overview = URL::createURL("admin", "analytics", "overview");
    $url_analytics_month    = URL::createURL("admin", "analytics", "month");
?>

<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo $picture ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Hello, <?php echo $fullName ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="seach" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="sidebar-index">
            <a href="<?php echo $url_dashboard?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        
        <!-- CONFIG BAR -->
        <li class="treeview sidebar-config">
            <a href="#">
                <i class="fa fa-cog"></i> <span>Config</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class=""><a href="#"><i class="fa fa-angle-double-right"></i>Email</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i>Image</a></li>
            </ul>
        </li>
        
        <!-- GROUP BAR -->
        <li class="sidebar-group">
            <a href="<?php echo $url_group ?>">
                <i class="fa fa-group"></i> <span>Group</span>
            </a>
        </li>

        <!-- USER BAR -->
        <li class="sidebar-user">
            <a href="<?php echo $url_user ?>">
                <i class="fa fa-user"></i> <span>User</span> <small class="badge pull-right bg-red">4</small>
            </a>
        </li>

        <!-- CATEGORY BAR -->
        <li class="sidebar-category">
            <a href="<?php echo $url_category?>">
                <i class="fa fa-suitcase"></i> <span>Category</span>
            </a>
        </li>

        <!-- BOOK BAR -->
        <li class="sidebar-book">
            <a href="<?php echo $url_book?>">
                <i class="fa fa-book"></i> <span>Book</span> <small class="badge pull-right bg-green">12</small>
            </a>
        </li>
        <!-- BOOK BAR -->
        <li class="sidebar-chapter">
            <a href="javascript:void(0)">
                <i class="fa fa-tags"></i> <span>Chapter</span> <small class="badge pull-right bg-green"></small>
            </a>
        </li>
        
        <!-- CART BAR -->
        <li class="sidebar-cart-book">
            <a href="<?php echo $url_cart_book?>">
                <i class="fa fa-shopping-cart"></i> <span>Shopping cart</span> <small class="badge pull-right bg-orange">1</small>
            </a>
        </li>

        <!-- Analytics -->
        <li class="treeview sidebar-analytics">
            <a href="#">
                <i class="fa fa-xing"></i> <span>Analytics</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="sidebar-menu-overview"><a href="<?php echo $url_analytics_overview?>"><i class="fa fa-angle-double-right"></i>Overview</a></li>
                <li class="sidebar-menu-month"><a href="<?php echo $url_analytics_month?>"><i class="fa fa-angle-double-right"></i>Month</a></li>
            </ul>
        </li>
    </ul>
</section>