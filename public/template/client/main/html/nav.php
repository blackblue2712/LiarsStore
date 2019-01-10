<?php
    
    if(!empty($this->_listCategory)){
        $xCate           = "";
        $xCateForSorting = "";
        foreach($this->_listCategory as $key => $value){
            $name = Helper::sliceStr($value->name, 3);
            $cateFilter = URL::filterURL($value->name);
            $url  = URL::createURL("client", "index", "index", array("category_id" => $value->id), "/cate-$cateFilter-$value->id.html");
            $xCate .= '<li><a data-id="'.$value->id.'" href="'.$url.'" title="'.$value->name.'">'.$name.'</a></li>';
            $xCateForSorting .= '<li><a tabindex="0"><label class="checkbox"><input name="form[search_category][]" type="checkbox" value="'.$value->id.'">'.$value->name.'</label></a></li>';
        }
    }else{
        $xCate = "Updaing...";
    }

    $urlHome = URL::createURL("client","index", "index", null, "/index.html");
    
?>
<nav>
    <div class="container">
        <ul id="mega-menu-1">
            <li class=""><a href="<?php echo $urlHome?>">Home</a></li>
            <li>
                <a class="dc-mega">Genres<span class="dc-mega-icon"></span></a>
                <div class="sub-container" style="top: 46px; z-index: 1000;">
                    <ul class="sub">
                        <?php echo $xCate?>
                    </ul>
                </div>
            </li>
            <li>
                <a class="dc-mega">Status<span class="dc-mega-icon"></span></a>
                <div class="sub-container" style="top: auto; z-index: 1000;">
                    <ul class="sub">
                        <li><a href="#">Complete</a></li>
                        <li><a href="#">Updating</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="dc-mega">Top View<span class="dc-mega-icon"></span></a>
                <div class="sub-container" style="top: auto; z-index: 1000;">
                    <ul class="sub">
                        <li><a href="#">Day</a></li>
                        <li><a href="#">Week</a></li>
                        <li><a href="#">Month</a></li>
                        <li><a href="#">Season</a></li>
                        <li><a href="#">Year</a></li>
                        <li><a href="#">All</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="dc-mega">Top Comment<span class="dc-mega-icon"></span></a> 
                <div class="sub-container" style="top: auto; z-index: 1000;">
                    <ul class="sub">
                        <li><a href="#">This season</a> </li>
                        <li><a href="#">Last season</a> </li>
                        <li><a href="#">Year</a> </li>
                        <li><a href="#">All</a> </li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="dc-mega">Year<span class="dc-mega-icon"></span></a> 
                <div class="sub-container" style="top: auto; z-index: 1000;">
                    <ul class="sub">
                        <li><a href="#">2018</a></li>
                        <li><a href="#">2017</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">FAQ</a></li>
            <li class="">
                <a class="dc-mega">Contact<span class="dc-mega-icon"></span></a>
            </li>
        </ul>
    </div>
</nav>
