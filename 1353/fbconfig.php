<?php
//Fonte: http://www.krizna.com/demo/login-with-facebook-using-php/
session_start();
// added in v4.0.0
require_once 'autoload.php';
require_once 'functions.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '1510121465959695','d17d6a3f13c8a8ba21bbde9f0ceda096' );
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://www.esportes.co/1353/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,email,first_name,last_name,link,gender,locale,picture,timezone,updated_time,verified' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');
 	    $fbfullname = $graphObject->getProperty('name');
	    $femail = $graphObject->getProperty('email');
        $fbfirst_name = $graphObject->getProperty('first_name');
        $fblast_name = $graphObject->getProperty('last_name');
        $fblink = $graphObject->getProperty('link');
        $fbgender = $graphObject->getProperty('gender');
        $fblocale = $graphObject->getProperty('locale');
        $fbpicture = "teste";
        //    $graphObject->getProperty('picture')->getProperty('data')->getProperty('url');
        $fbtimezone = $graphObject->getProperty('timezone');
        $fbupdated_time = $graphObject->getProperty('updated_time');
        $fbverified = $graphObject->getProperty('verified');
    
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
	    $_SESSION['first_name'] = $fbfirst_name;           
        $_SESSION['last_name'] = $fblast_name;
	    $_SESSION['link'] =  $fblink;
	    $_SESSION['gender'] = $fbgender;           
        $_SESSION['locale'] = $fblocale;
	    $_SESSION['picture'] =  $fbpicture;
	    $_SESSION['timezone'] = $fbtimezone;           
        $_SESSION['updated_time'] = $fbupdated_time;
	    $_SESSION['verified'] =  $fbverified;
    /* ---- header location after session ----*/
    checkuser($fbid, $fbfullname, $femail, $fbfirst_name, $fblast_name, $fbage_range, $fblink, $fbgender, $fblocale, $fbpicture, $fbtimezone, $fbupdated_time, $fbverified); // To update local DB
  header("Location: ../mapa.php");
} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}
?>