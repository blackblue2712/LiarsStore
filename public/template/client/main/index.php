<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->_title;?></title>
</head>
<?php
    echo $this->_fileCss;
	echo $this->_fileJs;
?>
<script type="text/javascript" src="http://localhost:8080/socket.io/socket.io.js"></script>
<script type="text/javascript" src="/LiarsStore/application/module/client/server/appClient.js"></script>
<body>
    <?php require_once PATH_TEMPLATE . DS . "client/main/html/header.php" ?>
	<!-- NAV BAR -->
	<?php require_once PATH_TEMPLATE . DS . "client/main/html/nav.php" ?>
	<!-- END NAV BAR -->
	<div class="clear"></div>
	<div class="row ad-container banner-top">
		<div class="col-lg-12">
			<div class="ad-center-980">
			</div>
		</div>
	</div>

	<!-- CONTAINER -->
	<div class="container main-container">
		<div class="row ad-container banner-top"><div class="col-lg-12"><div class="ad-center-980"></div></div></div>
		<!-- BREADCRUMB -->
		<?php require_once PATH_TEMPLATE . DS . "client/main/html/breadcrumb.php" ?>
		<!-- END BREADCRUMB -->

		<!-- SORTING -->
		<?php
			if($this->params["action"] == "index" && $this->params["controller"] == "index"){
				require_once PATH_TEMPLATE . DS . "client/main/html/sorting.php";
			}
		?>
		<!-- END SORTING -->


		<!-- ROW MAIN CONTENT -->
        <!-- SILDER -->
        <?php require_once PATH_TEMPLATE . DS . "client/main/html/slider.php" ?>
        <!-- MAIN CONTENT -->
        <div class="row">
            <?php require_once $this->_fileView ?>
            <?php require_once PATH_TEMPLATE . DS . "client/main/html/right-content.php" ?>
        </div>
		<!-- END MAIN CONTENT -->
		

		<!-- END ROW MAIN CONTENT -->
	</div><!-- END CONTAINER -->

	






	<!-- FOOTER -->
	<?php require_once PATH_TEMPLATE . DS . "client/main/html/footer.php" ?>
	<!-- END FOOTER -->
</body>
</html>
