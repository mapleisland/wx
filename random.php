<?php
function nonstr() {
  $dict = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
  $str = '';
  for ($i=0; $i < 11; $i++) {
    $r = rand(0,60);
    $str .= $dict[$r];
  }
  return $str;
}
function shastr($str) {
  return sha1($str);
}

$r = nonstr();
$s = shastr($r);
echo $r;
echo '<br>';
echo $s;
?>