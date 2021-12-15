<?php

  require_once HELPERS_DIR . 'DB.php';

  function haePelihuoneet() {
    return DB::run('SELECT * FROM pelihuone ORDER BY nimi;')->fetchAll();
  }

  function haePelihuone($id) {
    return DB::run('SELECT * FROM pelihuone WHERE idpelihuone = ?;',[$id])->fetch();
  }


?>