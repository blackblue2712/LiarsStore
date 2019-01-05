<?php
	include_once "C:/xampp/htdocs/LiarsStore/define.php";
	include_once PATH_EXTENDS . DS . "/Facebook/autoload.php";
	$fb = new Facebook\Facebook(
		[
			"app_id" => "2193977410815932", 						//my app id
			'app_secret' => "e48beebeb353adbedea5cbfcf0fcb0cb",					//my app secret
    		'default_graph_version' => "v3.2", 			//current version
		]
	);

	$helper 		= $fb->getRedirectLoginHelper();
    // $permissions 	= ['email', 'id', 'name', 'picture'];
	$URLCallback 	= "http://localhost/LiarsStore/fb-callback.php";
	echo $loginUrl 		= $helper->getLoginUrl($URLCallback);
	// me?fields=id,name,picture,email