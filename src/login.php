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
     <h1> Student Login Form </h1></header> 
    <form>  
        <div class="container">
            <h1>Login</h1>
            <p>Please fill in this form to log in to your account</p>
            <div id = "l1">
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" name="username" required></div>
            <div id = "l2">
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required></div>
            <button type="submit">Login</button>   
            <input type="checkbox" checked="checked"> Remember me   
            <button type="button" class="cancelbtn"> Cancel</button>   
            Forgot <a href="#"> password? </a>   
        </div>   
    </form>     
</body>
</html>