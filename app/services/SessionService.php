<?php

use Firebase\JWT\Key;

class SessionService {

    public static string $SECRET_KEY = "fjnljaicnuwe8nuwvo8nfulvieufksvfukenkfnelvnuf";


    public function create($data){
        $payload = [
            "id" => $data['id'],
            "email" => $data['email']
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, self::$SECRET_KEY,'HS256');
        setcookie(COOKIE_NAME, $jwt, time() + (60 * 60 * 24 * 30), "/", '', false, true);

    }

    public function getCurrentSession(){
      
        if($_COOKIE[COOKIE_NAME]){
            $jwt = $_COOKIE[COOKIE_NAME];
            try{
                $payload = \Firebase\JWT\JWT::decode($jwt, new Key(self::$SECRET_KEY, 'HS256'));
                return $payload;
            }catch(Exception $e){
                // die($e->getMessage());
                return false;
            }
        }else{
            return false;
        }
    }

    public function destroy(){
        setcookie(COOKIE_NAME, '', 1, "/");
    }
}