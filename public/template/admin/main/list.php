<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liars</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-black">
        <?php include_once "html/header.php" ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <?php include_once "html/sidebar.php" ?>
            </aside>
            <aside class="right-side">
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
                            <a class="btn btn-app">
                                <i class="fa fa-refresh"></i> Reload
                            </a>
                            <a class="btn btn-app">
                                <i class="fa fa-plus"></i> Add
                            </a>
                            <a class="btn btn-app">
                                <i class="fa fa-check"></i> Publish
                            </a>
                            <a class="btn btn-app">
                                <i class="fa fa-circle-o"></i> Unpublish
                            </a>
                            <a class="btn btn-app">
                                <i class="fa fa-minus"></i> Delete
                            </a>   
                        </div>
                    </div>
                    <!-- ALERT MESSAGE -->
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-check"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <b>Alert!</b> Success alert preview. This alert is dismissable.
                    </div>

                    <!-- TABLE -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Hover Data Table</h3>
                        </div>
                        
                        <div class="box-body table-responsive">

                        <!-- SELECT -->
                            <!-- type find -->
                        <div class="col-md-6">
                            <div class="input-group input-sm" style="margin-bottom:30px">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select by Name <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Select by Email</a></li>
                                        <li><a href="#">Select All</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                <div class="input-group">
                                    <input type="text" class="form-control" style="width:240px">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-flat" type="button"><i class="fa fa-eraser"></i></button>
                                        <button class="btn btn-default btn-flat" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                    <!-- select-find -->
                            </div><!-- end select -->
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right">
                                <select class="form-control input-sm" size="1">
                                    <option>Select by Group</option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select>
                            </div>

                            <div class="pull-right" style="margin-right:2px">
                                <select class="form-control input-sm" size="1">
                                    <option>Select by Status</option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                </select>
                            </div>
                        </div>
                        

                        <!-- TABLE CONTENT -->
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table id="example2" class="table table-bordered table-hover dataTable text-center">
                                <thead>
                                    <tr role="row">
                                        <th class="small-col" width="40px">
                                            <input type="checkbox" id="check-all" name=""></th>
                                        <th class="sorting_asc" >Browser</th>
                                        <th class="sorting_desc" >Platform(s)</th>
                                        <th class="sorting" >Engine version</th>
                                        <th class="sorting" >CSS grade</th>
                                        <th class="sorting" >Ordering</th>
                                        <th class="sorting" >Status</th>
                                        <th class="sorting" >ID</th>
                                    </tr>
                                </thead>
                                
                                
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <tr class="even">
                                        <td class=""><input type="checkbox"></td>
                                        <td class=" ">Netscape Browser 8</td>
                                        <td class=" ">Win 98SE+</td>
                                        <td class=" ">1.7</td>
                                        <td class=" ">A</td>
                                        <td class=" "><input type="text" name="ordering" size="1"></td>
                                        <td class=" "><a class=" label label-success"><i class="fa fa-check"></i></a></td>
                                        <td class="id">1</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="r"><input type="checkbox"></td>
                                        <td class=" ">Netscape Navigator 9</td>
                                        <td class=" ">Win 98+ / OSX.2+</td>
                                        <td class=" ">1.8</td>
                                        <td class=" ">A</td>
                                        <td class=" "><input type="text" name="ordering" size="1"></td>
                                        <td class=" "><a class=" label label-success"><i class="fa fa-check"></i></a></td>
                                        <td class="id">2</td>
                                    </tr>
                                    <tr class="even">
                                        <td class=""><input type="checkbox"></td>
                                        <td class=" ">Mozilla 1.0</td>
                                        <td class=" ">Win 95+ / OSX.1+</td>
                                        <td class=" ">1</td>
                                        <td class=" ">A</td>
                                        <td class=" "><input type="text" name="ordering" size="1"></td>
                                        <td class=" "><a class=" label label-success"><i class="fa fa-check"></i></a></td>
                                        <td class="id">3</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- END TABLE -->

                            <!-- PAGINATION -->
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="dataTables_info" id="example2_info">Showing 1 to 10 of 57 entries</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="dataTables_paginate paging_bootstrap">
                                    <ul class="pagination">
                                        <li class="prev disabled"><a href="#">← Prev</a></li>
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li class="next"><a href="#">Next → </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <!-- END PAGINATION -->
                    </div>
                    
                </section>
            </aside>
        </div>
    </body>


    <!-- add new calendar event modal -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/AdminLTE/app.js"></script>
    <script type="text/javascript" src="js/AdminLTE/demo.js"></script>
    <script type="text/javascript" src="js/plugins/iCheck/icheck.min.js"></script>
    <!-- Page script -->
    
</html>
