<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();

  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Ação não disponível");
    die(header('Location: ../pages/denied.php'));
  } 
  if($_POST['role'] == null) { 
    $_POST['role'] = 3;
  }
  $db = getDatabaseConnection();
  $user = User::getUser($db, intval($_GET['id']));

  
  $_SESSION['input']['role oldUser'] = intval(($_POST['role']));
  $_SESSION['input']['username oldUser'] = htmlentities($_POST['username']);
  $_SESSION['input']['name oldUser'] = htmlentities($_POST['name']);
  $_SESSION['input']['email oldUser'] = htmlentities($_POST['email']);
  $_SESSION['input']['password1 oldUser'] = htmlentities($_POST['password1']);
  $_SESSION['input']['password2 oldUser'] = htmlentities($_POST['password2']);
  $_SESSION['input']['csrf oldUser'] = htmlentities($_POST['csrf']);
  
  $stmt = $db->prepare('SELECT * FROM user WHERE email = ? and email != ?');
  $stmt->execute(array($_POST['email'], $user->email));
  $test = $stmt->fetch();
  if($test) { 
    $session->addMessage('warning','Email já existe');
    die(header('Location: ../edit/profile.edit.php?id='.$_SESSION['id']));
  }

  $stmt1 = $db->prepare('SELECT * FROM user WHERE username = ? and username != ?');
  $stmt1->execute(array($_POST['username'], $user->username));
  $test1 = $stmt1->fetch();
  if($test1) { 
    $session->addMessage('warning','Username já existe');
    die(header('Location: ../edit/profile.edit.php?id='.$_SESSION['id']));
  }


  
  
  
  $pass = User::getPass($db, intval($_GET['id']));

  if (!(valid_name($_POST['name'])) && valid_email($_POST['email']) && valid_CSRF($_POST['csrf'])) {
      die(header('Location: ../edit/profile.edit.php?id='.$user->id));
  }
  if ($user) {
    if($_POST['role'] == 3) { 
     $_POST['role'] = $user->role;
    }
    else if($_SESSION['role'] == 0 || $_SESSION['role'] == 1){
    $user->role = intval($_POST['role']);}
    $user->username = $_POST['username'];
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];

    

    if ($_POST['password1'] != "" ){

      if(!password_verify($_POST['password1'], $pass)){
        $session->addMessage('warning','Introduz corretamente a tua palavra passe');
        die(header('Location: ../edit/profile.edit.php?id='.$user->id));
      }

      if (!valid_password($_POST['password2'])) {
        die(header('Location: ../edit/profile.edit.php?id='.$user->id));}
      else if($_POST['password2'] == "") {
        $pass2 = $_POST['password1'];
        User::savePass($db, $user->id, $pass2);
      }
      else if(valid_password($_POST['password2'])) {
        $pass2 = $_POST['password2'];
        User::savePass($db, $user->id, $pass2);
      }
    }
    else if($_POST['password1'] == "" && $_POST['password2'] != ""){
      $session ->addMessage('warning','Por favor introduz a tua palavra passe atual para alterar para uma nova');
      die(header('Location:../edit/profile.edit.php?id='.$user->id));
    }

    if (!valid_name($_POST['name']) || !valid_email($_POST['email']) || !valid_CSRF($_POST['csrf'])) {
      die(header('Location: ../edit/profile.edit.php?id='.$user->id));
    } 
    if($_SESSION['id'] == $user->id){
    $_SESSION['name'] = $user->getName();
      $_SESSION['role'] == $user->role;
  }
    $user->save($db);
}

  unset($_SESSION['input']);

  $session->addMessage('success', "Alterações gravadas com sucesso");
  header('Location: ../pages/profile.php?id='. $user->id);
?>

