<?php

require_once('curl.class.php');

class Wx {

  //access_token是公众号的全局唯一接口调用凭据
  public static function accessToken($appid,$secret) {
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
    $response = Curl::curl_get_request_ssl($url);
    $response_arr = json_decode($response,true);
    return $response_arr;

    // 成功返回json
    // {
    //   "access_token":"ne5eoOIHnsVQvT9twHvDboisndqZa6U16G9pJnA8qDCgiqK-3YdMFmyFQki18eO6jS9UAO3hLBn_tyR9WO6xpWOCi-_tLLprhtDDy4zWqBykqNQ8TCHOZ0-hLTCSX8coODNgABAXMW",
    //   "expires_in":7200
    // }
  }

  //jsapi_ticket是公众号用于调用微信JS接口的临时票据
  public static function jsapiTicket($access_token) {
    $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
    $response = Curl::curl_get_request_ssl($url);
    $response_arr = json_decode($response,true);
    return $response_arr;

    // 成功返回json
    // {
    //   "errcode":0,
    //   "errmsg":"ok",
    //   "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
    //   "expires_in":7200
    // }
  }


  

  //获取带参数的二维码的过程包括两步,首先创建二维码ticket,然后凭借ticket到指定URL换取二维码。
  public static function qrCodeTicket($access_token,$jsondata) {
    $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
    $response = Curl::curl_post_request_ssl($url,$jsondata);
    $response_arr = json_decode($response,true);
    return $response_arr['ticket'];
  }

  //凭借二维码ticket到指定URL换取二维码
  public static function imgUrlFromTicket($ticket) {
    $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
    return $url;
  }

  //凭借二维码ticket到指定URL换取二维码
  public static function imgStreamFromTicket($ticket) {
    $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
    $response = curl_get_request_ssl($url);
    return $response;
  }

  public static function getOneImg($access_token='',$jsondata) {
    if($access_token == '') {
      exit();
    }
    $ticket = getQRCodeTicket($access_token,$jsondata);
    return getImgFromTicket($ticket);
  }

}