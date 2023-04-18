<?php
  declare(strict_types = 1);

  class User {

    public int $id;
    public int $role;
    public string $username;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(int $id, int $role, string $username, string $name, string $email, string $password) { 
      $this->id = $id;
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
      if ($user !== false && $email == $user['email'] && ($password == $user['password'] || password_verify($password, $user['password']))) {
        return new User(
          intval($user['id']),
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
        );
      } else return null;
    }

    public function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    static function getUser(PDO $db, int $id) : User {
      
      $stmt = $db->prepare('SELECT id,role,username,name,email,password FROM user WHERE id = ?');
      $stmt->execute(array(intval($id)));
      $user = $stmt->fetch();     
      return new User(
          $user['id'],
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          
      );
      
    } 
    function save($db) {
      $stmt = $db->prepare('UPDATE user SET username = ?, name = ?, email = ? WHERE id = ?');
      $stmt->execute(array($this->username, $this->name, $this->email,$this->id));
  } 
}

?>