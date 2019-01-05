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

                    <!-- INFO -->
                    <div class="row">
                        <div class="page-header">
                            <h1>Example page header <small>Subtext for header</small></h1>
                        </div>
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
    <script type="text/javascript">
        $(document).ready(function(){
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            //When unchecking the checkbox
            $("#check-all").on('ifUnchecked', function(event) {
                //Uncheck all checkboxes
                $("input[type='checkbox']").iCheck("uncheck");
            });
            
            //When checking the checkbox
            $("#check-all").on('ifChecked', function(event) {
                //Check all checkboxes
                $("input[type='checkbox']").iCheck("check");
            });

        });
    </script>
</html>
