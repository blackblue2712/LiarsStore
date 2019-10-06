<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> <?php echo $this->_title ?> </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <?php echo $this->_fileCss; ?>
        <?php echo $this->_fileJs; ?>
        <script type="text/javascript" src="http://localhost:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="/LiarsStore/application/module/admin/server/app.js"></script>
    </head>
    <body class="skin-black">
        <?php include_once "html/header.php" ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <?php include_once "html/sidebar.php" ?>
            </aside>

            <!-- INCLUDE FILE VIEW -->
            <?php include_once $this->_fileView?>
        </div>
    </body>    
</html>