<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1> Student Login Form </h1>
    </header>
    <form method="post" action="login_handler.php">
        <div class="container">
            <h1>Login</h1>
            <p>Please fill in this form to log in to your account</p>
            <input name="username" class="w3-input w3-border" type="text" placeholder="Username" required="required">
            <input name="password" class="w3-input w3-border" type="password" placeholder="Password" required="required">
            <input type="submit" name="Submit" value="Login">
            Forgot <a href="#"> password? </a>
        </div>
    </form>
</body>
</html>
