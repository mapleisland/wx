<?php

require_once('wx.class.php');
require_once('sqlite.class.php');

class Utils {

  static private $appid = 'wx5fcb7878b2e10ecc';
  static private $secret = 'd87dd0e4348b147ba6ae50b585924ca5';

  static public function somethingExpire($timextamp,$expire_in) {
    $now = time();
    $expire = $timextamp + $expire_in;
    $remain = $expire - $now;
    if($remain > 100) {
      return false;
    }
    else {
      return true;
    }
  }

  static public function getAccessToken() {
    $timextamp = time();

    $db = new Sqlite();
    $access_token = $db->getAccessToken();

    if($access_token) {
      $expire = self::somethingExpire($access_token['timextamp'],$access_token['expires_in']);
      if(!$expire) {
        return $access_token['access_token'];
      }
      else {
        $result = wx::accessToken(self::$appid,self::$secret);
        $update_result = $db->updateAccessToken($result['access_token'],$result['expires_in']);
        return $result['access_token'];
      }
    }
    else {
      //新数据库,还没有插入一条数据
      $result = wx::accessToken(self::$appid,self::$secret);
      $insert_result = $db->insertAccessToken($result['access_token'],$result['expires_in']);
      return $result['access_token'];
    }
  }

  static public function getJsapiTicket() {
    $access_token = self::getAccessToken();
    $timextamp = time();

    $db = new Sqlite();
    $jsapiTicket = $db->getJsapiTicket();

    if($jsapiTicket) {
      $expire = self::somethingExpire($jsapiTicket['timextamp'],$jsapiTicket['expires_in']);
      if(!$expire) {
        return $jsapiTicket['jsapi_ticket'];
      }
      else {
        $result = wx::jsapiTicket($access_token);
        $update_result = $db->updateJsapiTicket($result['ticket'],$result['expires_in']);
        return $result['ticket'];
      }
    }
    else {
      //新数据库,还没有插入一条数据
      $result = wx::jsapiTicket($access_token);
      $insert_result = $db->insertJsapiTicket($result['ticket'],$result['expires_in']);
      return $result['ticket'];
    }
  }

  static public function initdb() {
    $db = new Sqlite();
    $db->createTableAccessToken();
    $db->createTableJsapiTicket();
    $db->createTableRecords();
  }

}