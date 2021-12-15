<?php $this->layout('template', ['title' => $pelitapahtuma['nimi']]) ?>

<?php
  $start = new DateTime($pelitapahtuma['tap_alkaa']);
  $end = new DateTime($pelitapahtuma['tap_loppuu']);
?>

<h1><?=$pelitapahtuma['nimi']?></h1>
<div><?=$pelitapahtuma['kuvaus']?></div>
<br>
<div><span style= "font-weight:bold">Alkaa</span>: <?=$start->format('j.n.Y G:i')?></div>
<div><span style= "font-weight:bold">Loppuu</span>: <?=$end->format('j.n.Y G:i')?></div>

<?php
  if ($loggeduser) {
    if (!$osallistuminen) {
      echo "<div class='flexarea'><a href='ilmoittaudu?id=$pelitapahtuma[idpelitapahtuma]' class='button'>ILMOITTAUDU</a></div>";
    } else {
      echo "<div class='flexarea'>";
      echo "<div>Olet ilmoittautunut tapahtumaan!</div>";
      echo "<a href='peru?id=$pelitapahtuma[idpelitapahtuma]' class='button'>PERU ILMOITTAUTUMINEN</a>";
      echo "</div>";
    }
  }
?>
