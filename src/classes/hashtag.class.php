<?php
  declare(strict_types = 1);

  require_once('user.class.php');
  require_once('session.class.php');

  class Hashtag{

    public int $hashtag_id; 

    public string $tag;
    public function __construct(int $hashtag_id, string $tag) { 

        $this->hashtag_id = $hashtag_id; 

        $this->tag = $tag;

    }

    static public function getHashtag(int $hashtag_id) : string {
        
        $db = getDatabaseConnection(); 
        $stmt = $db->prepare('SELECT tag FROM hashtag WHERE hashtag_id = ?');
        $stmt->execute(array($hashtag_id));
        $tag = $stmt->fetch();
        return $tag['tag'];
        


    }



}


  ?> 