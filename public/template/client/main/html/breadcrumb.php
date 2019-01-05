<?php
    $breadcrumbLv1 = "";
    $breadcrumbLv2 = "";
    $breadcrumbLv3 = "";
    $breadcrumbLv4 = "";

    $url_home      = URL::createURL('client', 'index', 'index');
    if(isset($this->params["category_id"])){
        foreach($this->_listCategory as $value){
            if($this->params["category_id"] == $value->id){
                $breadcrumbLv2 = '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="#"><span itemprop="name">'. $value->name.'</span></a></li>';
                break;
            }
        }
    }
    if(isset($this->detailBook)){
        $breadcrumbLv1 = '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="#"><span itemprop="name">'. $this->detailBook["category_name"].'</span></a></li>';
        $breadcrumbLv2 = '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="#"><span itemprop="name">'. $this->detailBook["name"].'</span></a></li>';
    }

    if(isset($this->params["form"]["search_category"])){
        foreach($this->_listCategory as $key => $value){
            if( in_array($value->id, $this->params["form"]["search_category"])){
                $breadcrumbLv3 .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="#"><span itemprop="name">'. $value->name.'</span></a></li>';
            }
        }
    }

    if($this->params["controller"] != "index"){
        $breadcrumbLv4 .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="#"><span itemprop="name">'. $this->params["controller"].'</span></a></li>';
    }
?>
<ol class="breadcrumb" itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="<?php echo $url_home?>"><span itemprop="name">Home</span></a>
    </li>
    <?php echo $breadcrumbLv1.$breadcrumbLv2.$breadcrumbLv3.$breadcrumbLv4?>
</ol>