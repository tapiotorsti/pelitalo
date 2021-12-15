<?php


  //Tämä funktio lisää ensin saamansa tekstin perään satunnaisluvun ja 
  //laskee sen jälkeen niiden yhdistelmästä SHA1-hajautusluvun, 
  //joka on 40 heksanumeroa pitkä numerosarja. Kutsun yhteydessä tekstinä annetaan sähköpostiosoite. 
  //Tulos on esimerkiksi seuraavanlainen: cb322553380476c53b7be6f057f75f6102790374.
  
  function generateActivationCode($text='') {
    return hash('sha1', $text . rand());
  }

?>