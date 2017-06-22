<?php

class Sqlite {

  private $pdo;

  function __construct() {
    $this->pdo = new PDO("sqlite:db/data.db");
    $this->pdo->exec("SET NAMES 'utf8'");
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  // function createDb() {
  //   $sql = 'CREATE DATABASE IF NOT EXISTS database';
  //   return $this->pdo->exec($sql);
  // }

/*********************access_token**************************/

  //创建access_token中控数据表
  function createTableAccessToken() {
    $sql = "CREATE TABLE IF NOT EXISTS access_token (
      `access_token_id` int unsigned PRIMARY KEY,
      `access_token` text,
      `timextamp` int unsigned NOT NULL,
      `expires_in` int unsigned NOT NULL
    )";
    return $this->pdo->exec($sql);
  }

  function getAccessToken() {
    $sql = "SELECT * FROM `access_token` WHERE access_token_id = 1 LIMIT 1";
    $pre = $this->pdo->prepare($sql);
    $pre->execute();
    $access_token = $pre->fetch(PDO::FETCH_ASSOC);
    return $access_token;
  }

  function updateAccessToken($access_token,$expires_in) {
    $access_token_id = 1;
    $timextamp = time();
    $sql = "UPDATE access_token SET access_token = :access_token, expires_in = :expires_in, timextamp = :timextamp WHERE access_token_id = :access_token_id";
    $pre = $this->pdo->prepare($sql);
    $pre->bindParam(':access_token_id',$access_token_id);
    $pre->bindParam(':access_token',$access_token);
    $pre->bindParam(':expires_in',$expires_in);
    $pre->bindParam(':timextamp',$timextamp);
    $pre->execute();
    if($pre->rowCount() == 1) {
      return true;
    }
    else {
      return false;
    }
  }

  function insertAccessToken($access_token,$expires_in) {
    $access_token_id = 1;
    $timextamp = time();
    $sql = "INSERT INTO access_token (access_token_id,access_token,timextamp,expires_in) VALUES (:access_token_id,:access_token,:timextamp,:expires_in);";
    $pre = $this->pdo->prepare($sql);
    $pre->bindParam(':access_token_id',$access_token_id);
    $pre->bindParam(':access_token',$access_token);
    $pre->bindParam(':timextamp',$timextamp);
    $pre->bindParam(':expires_in',$expires_in);
    $pre->execute();
    if($pre->rowCount() == 1) {
      return true;
    }
    else {
      return false;
    }
  }

/*********************jsapi_ticket**************************/

  //创建jsapi_ticket中控数据表
  function createTableJsapiTicket() {
    $sql = "CREATE TABLE IF NOT EXISTS jsapi_ticket (
      `jsapi_ticket_id` int unsigned PRIMARY KEY,
      `jsapi_ticket` text,
      `timextamp` int unsigned NOT NULL,
      `expires_in` int unsigned NOT NULL
    )";
    return $this->pdo->exec($sql);
  }

  function getJsapiTicket() {
    $sql = "SELECT * FROM `jsapi_ticket` WHERE jsapi_ticket_id = 1 LIMIT 1";
    $pre = $this->pdo->prepare($sql);
    $pre->execute();
    $jsapiTicket = $pre->fetch(PDO::FETCH_ASSOC);
    return $jsapiTicket;
  }

  function updateJsapiTicket($jsapiTicket,$expires_in) {
    $jsapiTicket_id = 1;
    $timextamp = time();
    $sql = "UPDATE jsapi_ticket SET jsapi_ticket = :jsapi_ticket, expires_in = :expires_in, timextamp = :timextamp WHERE jsapi_ticket_id = :jsapi_ticket_id";
    $pre = $this->pdo->prepare($sql);
    $pre->bindParam(':jsapi_ticket_id',$jsapi_ticket_id);
    $pre->bindParam(':jsapi_ticket',$jsapi_ticket);
    $pre->bindParam(':expires_in',$expires_in);
    $pre->bindParam(':timextamp',$timextamp);
    $pre->execute();
    if($pre->rowCount() == 1) {
      return true;
    }
    else {
      return false;
    }
  }

  function insertJsapiTicket($jsapi_ticket,$expires_in) {
    $jsapi_ticket_id = 1;
    $timextamp = time();
    $sql = "INSERT INTO jsapi_ticket (jsapi_ticket_id,jsapi_ticket,timextamp,expires_in) VALUES (:jsapi_ticket_id,:jsapi_ticket,:timextamp,:expires_in);";
    $pre = $this->pdo->prepare($sql);
    $pre->bindParam(':jsapi_ticket_id',$jsapi_ticket_id);
    $pre->bindParam(':jsapi_ticket',$jsapi_ticket);
    $pre->bindParam(':timextamp',$timextamp);
    $pre->bindParam(':expires_in',$expires_in);
    $pre->execute();
    if($pre->rowCount() == 1) {
      return true;
    }
    else {
      return false;
    }
  }

/***********************************************/

  function wxidExist() {
    $sql = "SELECT wxid FROM `records` WHERE wxid = :wxid LIMIT 1";
    $pre = $this->pdo->prepare($sql);
    $pre->bindParam(':wxid',$wxid);
    $pre->execute();
    $result = $pre->fetch();
    return !empty($result);
  }

  //创建微信用户数据表
  function createTableRecords() {
    $sql = "CREATE TABLE IF NOT EXISTS records (
      `wxid` text PRIMARY KEY,
      `nameid` text NOT NULL,
      `timextamp` int unsigned NOT NULL
    )";
    return $this->pdo->exec($sql);
  }
  function scanQrCode() {
    $wxid = $fromUsername;
    $nameid = str_replace('qrscene_','',$EventKey);
    $timextamp = time();
    $wxidExist = $this->wxidExist($wxid);
    if(!$wxidExist) {
      $sql = "INSERT INTO records (wxid,nameid,timextamp) VALUES (:wxid,:nameid,:timextamp);";
      $pre = $this->pdo->prepare($sql);
      $pre->bindParam(':wxid',$wxid);
      $pre->bindParam(':nameid',$nameid);
      $pre->bindParam(':timextamp',$timextamp);
      $pre->execute();
      if($pre->rowCount() == 1) {
        $callback .= "ok";
      }
      else {
        $callback .= "not ok";
      }
    }
    else {
      $callback .= "您已经参加过了!";
    }
  }

}

