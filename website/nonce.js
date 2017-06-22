function genNonce() {
  var dict = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9'];
  var nonceStr = '';
  for (var i=0; i < 11; i++) {
    nonceStr += dict[getRandom(0,60)];
  }
  return nonceStr;
}

function getRandom(min,max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

