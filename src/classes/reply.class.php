<?php
  declare(strict_types = 1);

  require_once('ticket.class.php');
  require_once('session.class.php');

  class Reply { 
    public int $reply_id;

    public int $ticket_id;

    public int $id;

    public string $text;

    

    public function __construct(int $reply_id, int $ticket_id, int $id, string $text) { 
        $this->reply_id; 

        $this-> ticket_id;

        $this -> id; 

        $this -> text;
      }

      static public function getReplies(int $ticket_id) : array {
        $db = getDatabaseConnection(); 
        $stmt = $db->prepare('SELECT reply_id,ticket_id,id,text FROM reply WHERE ticket_id = ?');
        $stmt->execute(array(intval($ticket_id)));
        $text = $stmt->fetchall();

        return $text;
        

    }
}

?>
    
