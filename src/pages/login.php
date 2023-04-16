<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1> Student Login Form </h1>
    </header>
    <form action = "../actions/login.action.php" method = "post">
            <label>Email: <input type="email" name="email" value="<?=htmlentities($_SESSION['input']['email login'])?>"></label>
            <label>Password:<input type="password" name="password" value="<?=htmlentities($_SESSION['input']['password login'])?>"></label>
            <input id="button" type="submit" value="Entrar">
        </form>
</body>
</html>
