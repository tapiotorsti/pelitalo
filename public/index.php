<?php

  // Aloitetaan istunnot.
  session_start();

  // Suoritetaan projektin alustusskripti.
  require_once '../src/init.php';

  // Haetaan kirjautuneen käyttäjän tiedot.
  if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'kayttaja.php';
    $loggeduser = haeHenkilo($_SESSION['user']);
  } else {
    $loggeduser = NULL;
  }

  
 


  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/lanify/tapahtuma?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
  $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

  // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
  $templates = new League\Plates\Engine(TEMPLATE_DIR); 
  
  // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava
  // käsittelijä.
  switch ($request) {
    case '/':
    case '/pelitapahtumat':
      require_once MODEL_DIR . 'pelitapahtuma.php';
      $pelitapahtumat = haeTapahtumat();
      echo $templates->render('pelitapahtumat',['pelitapahtumat' => $pelitapahtumat]);
      break;
    case '/pelitapahtuma':
      require_once MODEL_DIR . 'pelitapahtuma.php';
      require_once MODEL_DIR . 'ilmoittautuminen.php';
      $pelitapahtuma = haeTapahtuma($_GET['id']);
      if ($pelitapahtuma) {
        if ($loggeduser) {
          $osallistuminen = haeIlmoittautuminen($loggeduser['idkayttaja'],$pelitapahtuma['idpelitapahtuma']);
        } else {
          $osallistuminen = NULL;
        }
        echo $templates->render('pelitapahtuma',['pelitapahtuma' => $pelitapahtuma,
                                             'osallistuminen' => $osallistuminen,
                                             'loggeduser' => $loggeduser]);
      } else {
        echo $templates->render('tapahtumanotfound');
      }
      break;
    case '/ilmoittaudu':
      if ($_GET['id']) {
        require_once MODEL_DIR . 'ilmoittautuminen.php';
        $idpelitapahtuma = $_GET['id'];
        if ($loggeduser) {
          lisaaIlmoittautuminen($loggeduser['idkayttaja'],$idpelitapahtuma);
        }
        header("Location: pelitapahtuma?id=$idpelitapahtuma");
      } else {
        header("Location: pelitapahtumat");
      }
      break;
    case '/peru':
      if ($_GET['id']) {
        require_once MODEL_DIR . 'ilmoittautuminen.php';
        $idpelitapahtuma = $_GET['id'];
        if ($loggeduser) {
          poistaIlmoittautuminen($loggeduser['idkayttaja'],$idpelitapahtuma);
        }
        header("Location: pelitapahtuma?id=$idpelitapahtuma");
      } else {
        header("Location:pelitapahtumat");
      }
      break;
    case '/pelihuoneet':
      require_once MODEL_DIR . 'pelihuone.php';
      $pelihuoneet = haePelihuoneet();
      echo $templates->render('pelihuoneet',['pelihuoneet' => $pelihuoneet]);
      break; 
      case '/pelihuone':
        require_once MODEL_DIR . 'pelihuone.php';
        require_once MODEL_DIR . 'ilmoittautuminen.php';
        $pelihuone = haePelihuone($_GET['id']);
        if ($pelihuone) {
          if ($loggeduser) {
            $osallistuminen = haeIlmoittautuminen($loggeduser['idkayttaja'],$pelihuone['idpelihuone']);
          } else {
            $osallistuminen = NULL;
          }
          echo $templates->render('pelihuone',['pelihuone' => $pelihuone,
                                               'osallistuminen' => $osallistuminen,
                                               'loggeduser' => $loggeduser]);
        } else {
          echo $templates->render('tapahtumanotfound');
        }
        break;
      case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
          $formdata = cleanArrayData($_POST);
          require_once CONTROLLER_DIR . 'tili.php';
          $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);  
        if ($tulos['status'] == "200") {
          echo $templates->render('tili_luotu', ['formdata' => $formdata]);
          break;
        }
        echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
        break;
      } else {
        echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        break;
      }
    case "/kirjaudu":
      if (isset($_POST['laheta'])) {
        require_once CONTROLLER_DIR . 'kirjaudu.php';
        if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
          session_regenerate_id();
          $_SESSION['user'] = $_POST['email'];
          header("Location: " . $config['urls']['baseUrl']);
        } else {
          echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
        }
      } else {
        echo $templates->render('kirjaudu', [ 'error' => []]);
      }
      break;
    case "/logout":
      require_once CONTROLLER_DIR . 'kirjaudu.php';
      logout();
      header("Location: " . $config['urls']['baseUrl']);
      break;
    default:
      echo $templates->render('notfound');
  }

?> 