<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function test_method($var = 'test')
    {
        return $var;
    }
    function send_password_mobile($mobile_no, $password)
	{
		$authKey = "84215Aeu0Yhfnyc55470221";

	    //Multiple mobiles numbers separated by comma
	    $mobileNumber = $mobile_no;
	    
	    //Sender ID,While using route4 sender id should be 6 characters long.
	    $senderId = "LICENO";
	    
	    //Your message to send, Add URL encoding here.
	    $message = urlencode("LICENO Password $password");
	    
	    //Define route 
	    $route = "4";
	    //Prepare you post parameters
	    $postData = array(
	        'authkey' => $authKey,
	        'mobiles' => $mobileNumber,
	        'message' => $message,
	        'sender' => $senderId,
	        'route' => $route
	    );
	    
	    //API URL
	    $url="https://api.msg91.com/api/sendhttp.php?authkey='$authKey'&mobiles='$mobileNumber'&message='$message'&sender='$senderId'&route=4&country=91";

	    
	    // init the resource
	    $ch = curl_init();
	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_POST => true,
	        CURLOPT_POSTFIELDS => $postData
	        //,CURLOPT_FOLLOWLOCATION => true
	    ));
	    

	    //Ignore SSL certificate verification
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	    
	    //get response
	    $output = curl_exec($ch);
	    
	    //Print error if any
	    if(curl_errno($ch))
	    {
	        echo 'error:' . curl_error($ch);
	    }
	    
	    curl_close($ch);
	}
}