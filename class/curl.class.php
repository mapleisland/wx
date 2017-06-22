<?php

class Curl {

  public static function curl_get_request_ssl($url) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  public static function curl_post_request_ssl($url,$jsondata='') {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$jsondata);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }
  
}