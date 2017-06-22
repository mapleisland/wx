<?php

require_once('class/utils.class.php');

$access_token = Utils::getAccessToken();
echo $access_token;
