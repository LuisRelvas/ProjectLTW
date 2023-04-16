<?php
  declare(strict_types = 1);

  class User {

    public int $user_id;
    public int $role;
    public string $username;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(int $user_id, int $role, string $username, string $name, string $email, string $password) { 
      $this->user_id = $user_id;
      $this->role = $role;
      $this->username = $username;
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
    }
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {

      $stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
      $stmt->execute(array(strtolower($email)));
      $user = $stmt->fetch();
      if ($user !== false && password_verify($password, $user['password'])) {
        return new User(
          intval($user['user_id']),
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
        );
      } else return null;
    }

    public function getId() : int {
      return $this->user_id;
    }
    public function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    static function getUser(PDO $db, int $user_id) : User {

      $stmt = $db->prepare('SELECT user_id,role,username, name, email, password FROM user WHERE user_id = ?');
      $stmt->execute(array($user_id));
  
      $user = $stmt->fetch();
  
      return new User(
          intval($user['user_id']),
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          
      );
    }  
}

?>