<?php

require_once 'php-jwt-master/src/BeforeValidException.php';
require_once 'php-jwt-master/src/ExpiredException.php';
require_once 'php-jwt-master/src/SignatureInvalidException.php';
require_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

class Zoom_Api{
	//LB
    //private $zoom_api_key = '2LAic1TMT9iXsu_uMO8TEQ';
	//private $zoom_api_secret = '7fn7U0G2JZYJpAbqSteyGBwosrMBS3TdGrTy';
	//TMU
	private $zoom_api_key = 'yq_c_2tSRWWZ1qUxw4Oq2A';
	private $zoom_api_secret = 'bD6oTYAKR4vUU6sQCe9tC8KQcuqVL45Ow6UY';

    //function to generate JWT
	private function generateJWTKey() {
		$key = $this->zoom_api_key;
		$secret = $this->zoom_api_secret;
		$token = array(
			"iss" => $key,
			"exp" => time() + 3600 //60 seconds as suggested
		);
		return JWT::encode( $token, $secret );
    }
    
    //function to create meeting
    public function createMeeting($data = array()){
		$post_time  = $data['start_time'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

        $createMeetingArray = array();
        $createMeetingArray['topic']      = $data['topic'];
		$createMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
		$createMeetingArray['timezone']   = !empty($data['timezone']) ? $data['timezone'] : "America/Lima";
		$createMeetingArray['start_time'] = $start_time;
		$createMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
		$createMeetingArray['duration']   = $data['duration'];

        $createMeetingArray['settings']   = array(
			'allow_multiple_devices' => true,
			'auto_recording'    => "local",
			'host_video'        => false,
            'join_before_host'  => true,
			'mute_upon_entry'   => true,
            'participant_video' => false,
			//'host_save_video_order' => true,
            'enforce_login'     => false,
        );

        return $this->sendRequest($createMeetingArray);
    }

    //function to send request
    protected function sendRequest($data){
        //Enter_Your_Email
        $request_url = "https://api.zoom.us/v2/users/zoom@themeduniverse.com/meetings";

        $headers = array(
			"authorization: Bearer ".$this->generateJWTKey(),
			"content-type: application/json",
			"Accept: application/json",
		);

        $postFields = json_encode($data);

        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $request_url,
    	CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
    	CURLOPT_TIMEOUT => 45,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
    	CURLOPT_POSTFIELDS => $postFields,
	    CURLOPT_HTTPHEADER => $headers,
    	));

        $response = curl_exec($ch);
    	$err = curl_error($ch);
    	curl_close($ch);
        if (!$response) {
    		return $err;
		}
        return json_decode($response);
    }
}

?>
