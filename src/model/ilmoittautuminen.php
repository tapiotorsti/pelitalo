<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeIlmoittautuminen($idkayttaja,$idpelitapahtuma) {
    return DB::run('SELECT * FROM osallistuminen WHERE idkayttaja = ? AND idpelitapahtuma = ?',
                   [$idkayttaja, $idpelitapahtuma])->fetchAll();
  }

  function lisaaIlmoittautuminen($idkayttaja,$idpelitapahtuma) {
    DB::run('INSERT INTO osallistuminen (idkayttaja, idpelitapahtuma) VALUE (?,?)',
            [$idkayttaja, $idpelitapahtuma]);
    return DB::lastInsertId();
  }

  function poistaIlmoittautuminen($idkayttaja, $idpelitapahtuma) {
    return DB::run('DELETE FROM osallistuminen  WHERE idkayttaja = ? AND idpelitapahtuma = ?',
                   [$idkayttaja, $idpelitapahtuma])->rowCount();
  }

?>
