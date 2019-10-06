
<?php
include_once "C:/xampp/htdocs/LiarsStore/fb-config.php";

// Dòng này để fix khi không có session
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}


try {
	$accessToken = $helper->getAccessToken();
	if($accessToken){
		$_SESSION["access_token"] = $accessToken;

		//Lấy thông tin của người dùng trên Facebool
		$response 	= $fb->get('/me?fields=name,email', $accessToken->getValue());
		$fbUser 	= $response->getGraphUser();
		if(!empty($fbUser)){
			//Người dùng không có email
			if(!isset($fbUser["email"])){
				$_SESSION["msg"] 	= "Tài khoản facebook của bạn chưa cập nhật email!";
			}

			$_SESSION["username"] 	= $fbUser["name"];
			$_SESSION["email"] 		= $fbUser["email"];
			echo '<pre style=color:#176F08;font-weight:bold >';
			print_r($fbUser);
			echo '</pre>';
			echo '<pre style=color:#176F08;font-weight:bold >';
			print_r($_SESSION);
			echo '</pre>';
			
			header("location: index.php");
			exit;
		}
		
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}