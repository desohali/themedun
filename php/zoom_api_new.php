<?php
class Zoom_Api_New
{
    private $account_id = 'PgGahTagRrKZGWqzXChftA';
    private $client_id = 'T95yxD0eQoGRtILapMFEA';
    private $client_secret = '5v7x8sRkHoQya3ZrQs8QU8Y5JU6ZH3Bv';

    private $accessToken = '88888888';
    private $user = 'themeduniverseherramientas@gmail.com';


    public function refreshAccessToken($clientId, $clientSecret)
    {
        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $this->account_id;
        
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'header' => 'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret) // Agrega la autenticación Basic Auth
            )
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseData = json_decode($response, true);

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        }
        
        return null;
    }

    public function isAccessTokenExpired($accessToken)
    {
        @$tokenData = explode('.', $this->accessToken);
        //$decodedHeader = base64_decode($tokenData[0]);
        @$decodedPayload = base64_decode($tokenData[1]);

        @$payload = json_decode($decodedPayload, true);
        @$expirationTime = $payload['exp'];

        // Verificar si el token ha expirado en los próximos 5 minutos
        return time() >= ($expirationTime - 300);
    }

    public function createMeeting($meetingData = array())
    {
        if ($this->isAccessTokenExpired($this->accessToken)) {
            // Obtener un nuevo token de acceso
            $this->accessToken = $this->refreshAccessToken($this->client_id, $this->client_secret);
            if (!$this->accessToken) {
                exit();
            }
        }

        $createMeetingArray = array();
        $createMeetingArray['topic']      = $meetingData['topic'];
		$createMeetingArray['type']       = !empty($meetingData['type']) ? $meetingData['type'] : 2; //Scheduled
		$createMeetingArray['timezone']   = !empty($meetingData['timezone']) ? $meetingData['timezone'] : "America/Lima";
		$createMeetingArray['start_time'] = $meetingData['start_time'];
		$createMeetingArray['password']   = !empty($meetingData['password']) ? $meetingData['password'] : "";
		$createMeetingArray['duration']   = $meetingData['duration'];

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

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken,
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/" . $this->user . "/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($meetingData),
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if (!$response) {
    		return $err;
		}
        return json_decode($response);
    }
}

// EXAMPLE
/* $zoom = new Zoom_Api_New();
$response = $zoom->createMeeting(array(
    'topic' => 'Mi reunión',
    'type' => 2, // Tipo de reunión: 2 para reunión programada
    'start_time' => '2023-07-12T10:00:00', // Fecha y hora de inicio en formato ISO 8601
    'duration' => 60, // Duración de la reunión en minutos
    'timezone' => 'America/Lima', // Zona horaria de la reunión
    'password' => '123456', // Contraseña de la reunión (opcional)
    'agenda' => 'Agenda de la reunión' // Agenda de la reunión (opcional)
));
var_dump($response); */

?>