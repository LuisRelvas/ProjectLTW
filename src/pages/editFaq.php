<?php
  declare(strict_types = 1);
  require_once('../templates/common.php');
  require_once('../database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session();

    $db = getDatabaseConnection();
    drawHeader($session);
    if(!$session->isLoggedIn()) { 
        drawAcessDenied();
        $session->addMessage('error','Voce nao tem permissao para aceder a esta pagina');
        die();
    }
    if (count($session->getMessages())) drawMessages($session);
    drawEditFaqForm();
    drawFooter();




  ?>