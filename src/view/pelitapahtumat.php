<?php $this->layout('template', ['title' => 'Tulevat tapahtumat ja turnaukset']) ?>

<h1>Tulevat tapahtumat ja turnaukset</h1>

<div class='tapahtumat'>
<?php

foreach ($pelitapahtumat as $pelitapahtuma) {

  $start = new DateTime($pelitapahtuma['tap_alkaa']);
  $end = new DateTime($pelitapahtuma['tap_loppuu']);

  echo "<div>";
    echo "<div>$pelitapahtuma[nimi]</div>" . "<br>";
    echo "<div>" . $start->format('j.n.Y') . "-" . $end->format('j.n.Y') . "</div>";
    echo "<div><a href='pelitapahtuma?id=" . $pelitapahtuma['idpelitapahtuma'] . "'>Lue lisää</a></div>";
  echo "</div>";

}

?>

