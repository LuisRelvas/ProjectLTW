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
        if($tag){
          return $tag['tag'];
        }
        else  {
          return "null";
                }
        

    }

    static public function getHashtagID(string $tag) : int {
        
        $db = getDatabaseConnection(); 
        $stmt = $db->prepare('SELECT hashtag_id FROM hashtag WHERE tag = ?');
        $stmt->execute(array($tag));
        $tag = $stmt->fetch();
        return $tag['hashtag_id'];
    }

    
    static function search(PDO $db, string $search, string $type) : array {
      $querie = '';
      $result = array();
  
      switch ($type) {
        case "nameH1":
            $querie = 'SELECT * FROM hashtag WHERE tag LIKE ?';
            break;
        default:  
            return $result;
      }
    $stmt = $db->prepare($querie);
    $stmt->execute(array('%'.$search.'%'));
      while ($hashtag = $stmt->fetch()) {
        $result[] = new Hashtag(
          $hashtag['hashtag_id'],
          $hashtag['tag']
        );
      }
      return $result;

  }

  static function removeHashtag(PDO $db, int $hashtag_id) {
    $stmt = $db->prepare('DELETE FROM ticketHashtag WHERE hashtag_id = ?');
    $stmt->execute(array($hashtag_id));
  }
}


  ?> 