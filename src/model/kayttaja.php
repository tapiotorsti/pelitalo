<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaHenkilo($nimi,$email,$puhnro,$salasana) {
    DB::run('INSERT INTO kayttaja (nimi, email, puhnro, salasana) VALUE  (?,?,?,?);',[$nimi,$email,$puhnro,$salasana]);
    return DB::lastInsertId();
  }

  function haeHenkiloSahkopostilla($email) {
    return DB::run('SELECT * FROM kayttaja WHERE email = ?;', [$email])->fetchAll();
  }

  function haeHenkilo($email) {
    return DB::run('SELECT * FROM kayttaja WHERE email = ?;', [$email])->fetch();
  }

  /*function haeAdmin($admin) {
    return DB::run('SELECT * FROM kayttaja WHERE admin = ?;', [$admin])->fetch();
  }*/

  //funktio päivittää vahvistusavaimen tietokantaan käyttäjän sähköpostiosoitteen perusteella. 
  //Tätä käytetään generoidun vahvistusavaimen tallentamiseen silloin kun tiliä luodaan tai käyttäjä pyytää uutta vahvistusavainta.
  function paivitaVahvavain($email,$avain) {
    return DB::run('UPDATE kayttaja SET vahvavain = ? WHERE email = ?', [$avain,$email])->rowCount();
  }

  //funktio vahvistaa käyttäjän tilin määrittelemällä vahvistettu-arvon todeksi. 
  //Muutosrivi etsitään vahvistusavaimella, koska vahvistuslinkissä ei saa tietoturvasyistä ilmetä käyttäjän sähköpostiosoite.
  function vahvistaTili($avain) {
    return DB::run('UPDATE kayttaja SET vahvistettu = TRUE WHERE vahvavain = ?', [$avain])->rowCount();
  }

?>