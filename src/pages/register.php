<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register</title>
</head>
<body>
    <header>
        <h1>Register Page</h1>
    </header>
<div id = "form">
    <form action="../actions/addUser.action.php" method ="post">
          <label>id: <input type="text" name = "id" required="required" value="<?=htmlentities($_SESSION['input']['id newUser'])?>"></label>
          <label>username: <input type="text" name="username" required="required" value="<?=htmlentities($_SESSION['input']['username newUser'])?>"></label>
          <label>name: <input type="text" name="name" required="required" value="<?=$_SESSION['input']['name newUser']?>"></label>
          <label>Email: <input type="email" name="email" required="required" value="<?=htmlentities($_SESSION['input']['email newUser'])?>"></label>
          <label>Password: <input type="password" name="password1" required="required" value="<?=htmlentities($_SESSION['input']['password1 newUser'])?>"></label>
          <label>Confirme password: <input type="password" name="password2" required="required" value="<?=htmlentities($_SESSION['input']['password2 newUser'])?>"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="button" type="submit" value="Concluir registo">
      </form>
</div>
</body>
</html>