<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');
  $session = new Session();

    $db = getDatabaseConnection();
    $ticket_id = intval($_GET['ticket_id']);
    $text = $_POST['answer'];
    $stmt = $db->prepare('INSERT INTO reply(ticket_id, id, text) VALUES (?, ?, ?)');
    $stmt->execute(array($ticket_id, $_SESSION['id'], $text));
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id);