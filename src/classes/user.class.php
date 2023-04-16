<?php
  declare(strict_types = 1);

  class User {

    public int $user_id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(int $user_id, string $name, string $email, string $password) { 
      $this->user_id = $user_id;
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
    }

    public function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {

      $stmt = $db->prepare('SELECT * FROM User WHERE email = ?');
      $stmt->execute(array(strtolower($email)));
      $user = $stmt->fetch();
      if ($user !== false && password_verify($password, $user['password'])) {
        return new User(
          intval($user['user_id']),
          $user['name'],
          $user['email'],
          $user['password'],
        );
      } else return null;
    }

    static function getUsers(PDO $db, int $count) : array {

      $stmt = $db->prepare('SELECT user_id, name, email, password, address, phoneNumber FROM User LIMIT ?');
      $stmt->execute(array($count));
  
      $users = array();
      while ($user = $stmt->fetch()) {
        $users[] = new User(
          intval($user['user_id']),
          $user['name'],
          $user['email'],
          $user['password'],
        );
      }
  
      return $users;
    }

    static function getUser(PDO $db, int $id) : User {

      $stmt = $db->prepare('SELECT user_id, name, email, password, address, phoneNumber FROM User WHERE user_id = ?');
      $stmt->execute(array($id));
  
      $user = $stmt->fetch();
  
      return new User(
          intval($user['user_id']),
          $user['name'],
          $user['email'],
          $user['password'],
      );
    }  

    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET name = ?, email = ?, password = ?, address = ?, phoneNumber = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->name, $this->email, $this->password,$this->user_id));
    }
}

?>