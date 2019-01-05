<aside class="right-side">
<?php
    
    $url_add            = URL::createURL("admin", "group", "form");
    $url_edit           = URL::createURL("admin", "group", "form");
    $url_delete         = URL::createURL("admin", "group", "delete");
    $url_multiDelete    = URL::createURL("admin", "group", "multiDelete");
    $url_multiPublic    = URL::createURL("admin", "group", "multiPublic");
    $url_multiUnpublic  = URL::createURL("admin", "group", "multiUnpublic");

    //
    $column         = isset($this->params["filter_column"]) ? $this->params["filter_column"] : "";
    $column_dir     = isset($this->params["filter_column_dir"]) ? $this->params["filter_column_dir"] : "";
    $lbName         = Helper::cmsLinkSort("Name", "name", $column, $column_dir);
    $lbGroupAcp     = Helper::cmsLinkSort("ACP", "group_acp", $column, $column_dir);
    $lbStatus       = Helper::cmsLinkSort("Status", "status", $column, $column_dir);
    $lbOrdering     = Helper::cmsLinkSort("Ordering", "ordering", $column, $column_dir);
    $lbCreated      = Helper::cmsLinkSort("Created", "created", $column, $column_dir);
    $lbModified     = Helper::cmsLinkSort("Modified", "modified", $column, $column_dir);
    $lbId           = Helper::cmsLinkSort("ID", "id", $column, $column_dir);


    //Store  content_search
    $content_search = isset($this->params["content_search"]) ? $this->params["content_search"] : "";


    //MESSAGE
    $msg = "";
    if(isset($_SESSION["msg"])){
        $msg = Session::get("msg");
        $msg = '<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Alert!</b> '.$msg.'
            </div>';
        Session::delete("msg");
    }
    
?>
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>

        <!-- BUTTON APP -->
        <div class="row">
            <div class="main-button text-center" style="margin-top:30px">
                <a class="btn btn-app" href="javascript:reload()">
                    <i class="fa fa-refresh"></i> Reload
                </a>
                <a class="btn btn-app" href="<?php echo $url_add ?>">
                    <i class="fa fa-plus"></i> Add
                </a>
                <a class="btn btn-app" href="javascript:publicMulti('<?php echo $url_multiPublic?>')">
                    <i class="fa fa-check"></i> Publish
                </a>
                <a class="btn btn-app" href="javascript:unpublicMulti('<?php echo $url_multiUnpublic?>')">
                    <i class="fa fa-circle-o"></i> Unpublish
                </a>
                <a role="delete" id="delete" class="btn btn-app deleteMulti" href="javascript:deleteMulti('<?php echo $url_multiDelete ?>')">
                    <i class="fa fa-minus"></i> Delete
                </a>   
            </div>
        </div>
        <!-- ALERT MESSAGE -->
        <div class="message_alert">
            <?php echo $msg?>
        </div>
        

        <!-- TABLE -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Group Data Table</h3>
            </div>
            
            <div class="box-body table-responsive">

            <!-- SELECT -->
                <!-- type find -->
            <form action="#" id="adminForm" method="POST">
                <div class="col-md-6">
                    <div class="input-group input-sm" style="margin-bottom:30px">
                        <div class="input-group-btn typing_search">
                            <button role="name" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select by Name <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu">
                                <li role="email" ><a href="#">Select by Email</a></li>
                                <li role="all"><a href="#">Select All</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                        <div class="input-group">
                            <input type="text" class="form-control" id="content_search" name="content_search" style="width:240px" value="<?php echo $content_search ?>">
                            <span class="input-group-btn">
                                <button style="height:34px" class="btn btn-default btn-flat clear_content_search" type="button"><i class="fa fa-eraser"></i></button>
                                <button style="height:34px" class="btn btn-default btn-flat typing_search_action" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>

                            <!-- select-find -->
                    </div><!-- end select -->
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <select class="form-control input-sm" id="select_filter_acp" size="1">
                            <option value="default">Select by ACP</option>
                            <option value="1">Public</option>
                            <option value="0">Unpublic</option>
                        </select>
                    </div>

                    <div class="pull-right" style="margin-right:2px">
                        <select name="select_filter_status" class="form-control input-sm" id="select_filter_status" size="1">
                            <option value="default">Select by Status</option>
                            <option value="1">Public</option>
                            <option value="0">Unpublic</option>
                        </select>
                    </div>
                </div>
                

                <!-- TABLE CONTENT -->
                <div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <table id="example2" class="table table-bordered table-hover dataTable text-center">
                        <thead>
                            <tr role="row">
                                <th class="small-col" width="40px"><input type="checkbox" id="check-all" name=""></th>
                                <th class="sorting" ><?php echo $lbName ?></th>
                                <th class="sorting" width="8%"><?php echo $lbGroupAcp ?></th>
                                <th class="sorting" width="8%"><?php echo $lbStatus ?></th>
                                <th class="sorting" width="8%"><?php echo $lbOrdering ?></th>
                                <th class="sorting" width="15%"><?php echo $lbCreated ?></th>
                                <th class="sorting" width="15%"><?php echo $lbModified ?></th>
                                <th class="sorting" width="4%"><?php echo $lbId ?></th>
                            </tr>
                        </thead>
                        
                        <?php
                            $i = 0;
                            $xhtml = "";
                            
                            
                            foreach($this->listGroup as $key => $value){
                                $group_edit = URL::createURL("admin", "group", "form", array("id" => $value["id"]) );
                                $group_acp  = ($value["group_acp"] == 1)? Helper::createPublicHTML(array("element" => "group_acp", "id" => $value["id"])) : Helper::createUnpublicHTML(array("element" => "group_acp", "id" => $value["id"]));
                                $status     = ($value["status"] == 1)? Helper::createPublicHTML( array("element" => "status", "id" => $value["id"]) ) : Helper::createUnpublicHTML( array("element" => "status", "id" => $value["id"]) );
                                $class      = ($i % 2 == 0)? "even":"odd";

                                if($value["modified"] != "0000-00-00"){
                                    $dateMD     = new DateTime($value["modified"]);
                                    $timestampMD= $dateMD->getTimestamp();
                                    $modified   = date("d-m-Y", $timestampMD);
                                }else{
                                    $modified   = "<i>None</i>";
                                }
                                
                                if($value["created"] != "0000-00-00"){
                                    $dateCR     = new DateTime($value["created"]);
                                    $timestampCR= $dateCR->getTimestamp();
                                    $created    = date("d-m-Y", $timestampCR);
                                }else{
                                    $created    = "<i>None</i>";
                                }
                                

                                $xhtml .= '<tr class="'.$class.'">
                                            <td class=""><input name="multi_select[] " type="checkbox" value="'.$value["id"].'"></td>
                                            <td class="">
                                                <div class="col-md-5">
                                                    <a href = '.$group_edit.'>'.$value["name"].'</a>
                                                </div>
                                                <div class="col-md-1">|</div>
                                                <div class="col-md-6">
                                                    <a href = '.$group_edit.'>'.htmlentities($value["group_descript"]).'</a>
                                                </div>
                                            </td>
                                            <td class="show_group_acp_'.$value["id"].'">'.$group_acp.'</td>
                                            <td class="show_status_'.$value["id"].'">'.$status.'</td>
                                            <td class="show_ordering_'.$value["id"].'"><input style="width:50px;" class="text-center" type="number" name="ordering" data-id="'.$value["id"].'" value="'.$value["ordering"].'"></td>
                                            <td class="show_created_'.$value["id"].'">
                                                <span class="">'.$value["created_by"].'</span><span class="pull-right">'.$created.'</span>
                                            </td>
                                            <td class="show_modified_'.$value["id"].'">
                                            <span class="">'.$value["modified_by"].'</span><span class="pull-right">'.$modified.'</span>
                                            </td>
                                            <td class="show_id_'.$value["id"].'">'.$value["id"].'</td>
                                        </tr>';
                            }
                        ?>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php
                                echo $xhtml;
                            ?>
                        </tbody>
                    </table>
                    <!-- END TABLE -->

                    <!-- FILTER -->
                    <input type="hidden" name="filter_acp" value="default">
                    <input type="hidden" name="filter_column" value="id">
                    <!-- Đặt giống ở model để pagination -->
                    <input type="hidden" name="filter_column_dir" value="asc">
                    <input type="hidden" name="filter_typing" value="name">
                    <input type="hidden" name="filter_page" value="1">
                </form>
            <!-- PAGINATION --> 
            <center style="margin-top:40px">
                <?php
                    echo $this->pagination->showPaginationDF(null);
                ?>
            </center>
           
            <!-- <iframe src="\LiarsStore\application\module\admin\views\group\paging\paging.php" style="width:100%" frameborder="0"></iframe> -->
            <!-- END PAGINATION -->
        </div>
    </section>
</aside>

<script type="text/javascript">
    window.onload = function(){
        $("div.alert").delay(5000).slideUp();
        
    }

    <?php
        if(isset($this->params["filter_column"])){
            echo Helper::createScriptSort($column, $column_dir);
        }
    ?>
</script>

<?php
    // Gắn lại các select
    if(isset($this->params["filter_acp"])){
        if($this->params["filter_acp"] != "defalt")
        echo Helper::createScriptSelected("#select_filter_acp", $this->params["filter_acp"]);
    }
    // Gắn lại các select
    if(isset($this->params["select_filter_status"])){
        if($this->params["select_filter_status"] != "defalt")
        echo Helper::createScriptSelected("#select_filter_status", $this->params["select_filter_status"]);
    }
?>