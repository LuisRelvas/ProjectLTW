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

  $_SESSION['input']['role oldUser'] = intval(htmlentities($_POST['role']));
  $_SESSION['input']['username oldUser'] = htmlentities($_POST['username']);
  $_SESSION['input']['name oldUser'] = htmlentities($_POST['name']);
  $_SESSION['input']['email oldUser'] = htmlentities($_POST['email']);
  $_SESSION['input']['password1 oldUser'] = htmlentities($_POST['password1']);
  $_SESSION['input']['password2 oldUser'] = htmlentities($_POST['password2']);
  if (!(valid_name($_POST['name'])) && valid_email($_POST['email']) && valid_CSRF($_POST['csrf'])) {
      die(header('Location: ../edit/profile.edit.php'));
  }

  $db = getDatabaseConnection();

  $user = User::getUser($db, intval($_GET['id']));
  $pass = User::getPass($db, intval($_GET['id']));
  if ($user) {
    $user->role = intval($_POST['role']);
    $user->username = $_POST['username'];
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];

    if ($_POST['password1'] != "" && (password_verify($_POST['password1'], $pass))){

      if (!valid_password($_POST['password2'])) {
        die(header('Location: ../edit/profile.edit.php'));
      } else {
        $pass2 = $_POST['password2'];
        User::savePass($db, $user->id, $pass2);
      }

    } else if ($_POST['password1'] != "" && $pass != $_POST['password1']) {
      $session->addMessage('warning', "Para mudar a palavra passe necessita primeiro de colocar correctamente a antiga");
      die(header('Location: ../edit/profile.edit.php'));
    } 

    $user->save($db);

    if($_SESSION['id'] == $user->id){
    $_SESSION['name'] = $user->getName();}
  }

  unset($_SESSION['input']);

  $session->addMessage('success', "Alterações gravadas com sucesso");
  header('Location: ../pages/profile.php?id='. $user->id);
?>