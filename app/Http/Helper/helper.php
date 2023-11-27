<?php


if(!function_exists('gjwt_decode')){
    function gjwt_decode($token){
        try {
            $client = new GuzzleHttp\Client();
            $res = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token='.$token);
            // echo $res->getStatusCode(); // 200
            // echo $res->getBody();
            return ["data" => json_decode($res->getBody()), "status"=>$res->getStatusCode()];
        } catch(GuzzleHttp\Exception\ClientException $e){
            return ['status'=>"error"];
        }
        
        
    }
}
?>