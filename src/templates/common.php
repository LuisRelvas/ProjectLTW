<?php 
    declare(strict_types = 1);
    function drawHeader(Session $session) { ?>
        <!DOCTYPE html>
        <html lang="PT-pt">
            <head>
                <title>Trouble Ticket FEUP</title>
                <meta
                    name = "LTW Project"
                    encoding = "utf-8"
                    author = "Relvas, Domingos, Angy"
                >

                <link rel="stylesheet" href="../css/responsive.css">
                <link rel="stylesheet" href="../css/layout.css">
                <link rel="stylesheet" href="../css/style.css">
                <link rel="stylesheet" href="../css/messages.css">
                <link rel="stylesheet" href="../css/common.css">
                <link rel="stylesheet" href="../css/accordion.css">



                
                
                <script src="../javascript/showfaq.js" defer></script>
                <script src="../javascript/searchticket.js" defer></script>
                <script src="../javascript/searchprofile.js" defer></script>
                <script src="../javascript/searchtags.js" defer></script>
                <script src="../javascript/showallhashtags.js" defer></script>
                <script src="../javascript/showalldepartments.js" defer></script>
                <script src="../javascript/showallstatus.js" defer></script>
                <script src="../javascript/showalert.js" defer></script>
            </head>
            <body>
                <header>
                        <div class = "logo">
                            <a href="../pages/index.php">
                                <img src="https://dec.fe.up.pt/wp-content/uploads/2021/03/logo-feup-white.png" alt="Logo of FEUP">
                            </a>
                        </div>
                        
                        <?php
                            if ($session->isLoggedIn()) 
                            drawLoginUser($session->getId(), $session->getName());
                            else drawDefaultUser();
                        ?>
            
                </header>
            </body>
            <main>
            <?php 
        }

        function drawLoginUser(int $id, string $name) { ?>

            <div id="login">
                <button clickable onclick="location.href='../actions/logout.action.php'">
                    Logout
                </button>

                <button clickable onclick="location.href='../pages/profile.php?id=<?=$id?>'">
                    <?=$name?>
                </button>
            
            </div>
        <?php 
        }

        function drawDefaultUser() { ?>
            <div id="login">
                <button onclick="location.href='../pages/login.php'">
                    Login
                </button>

                <button onclick="location.href='../pages/register.php'">
                    Register
                </button>
                <button onclick="location.href='../pages/index.php'">
                    FAQ


            
            </div>
        <?php 
        }

        function drawLogin() { ?>
            <section id="loginpage">
                <h1>Login</h1>
                <form action = "../actions/login.action.php" method = "post">
                    <label>Email: <input type="email" name="email" placeholder="email"></label>
                    <label>Password:<input type="password" name="password" placeholder="password"></label>
                    <input id="button" type="submit" value="Entrar">
                </form>
            </section> <?php 
        }

        function drawBanner() { ?>
            
    <nav id="menu">
      <input type="checkbox" id="hamburger"> 
      <label class="hamburger" for="hamburger"></label>

      <ul>
        <li><a href="../pages/ticketsee.php">My Tickets</a></li>
        <li><a href="../pages/ticketadd.php">Add Ticket</a></li>
        <li><a href="../pages/ticketmanage.php">Manage Ticket</a></li>
      </ul>
    </nav><?php 
        }

        function drawAcessDenied() { ?>
            <section id="accessDenied">
                <img id= "deniedImage" src="https://cdn-icons-png.flaticon.com/512/175/175613.png" alt="Access Denied">
                <h2>Access Denied!</h2>
                <h3>Sorry, you do not have permission to access this page.</h3>
                <p>You're being redirected...</p>
            </section> 
            <script src="../javascript/showAcessDenied.js" defer></script>
        <?php }  

        function drawMessages(Session $session) {
            echo '<div id="popup-container">';
            
            foreach ($session->getMessages() as $message) {
                echo '<div class="popup-alert ' . $message['type'] . '">';
                echo '<i class="fas fa-exclamation-circle"></i>';
                echo '<p>' . $message['text'] . '</p>';
                echo '</div>';
            }
            
            echo '</div>';
        }

        



function drawFooter() { ?>
    </main>
    <footer>
        <div class="footer"> 
            <nav>
                <h3><a href="../pages/index.php">Termos e Serviços</a></h3>
                <h3><a href="../pages/index.php">Fale connosco</a></h3>
                <h3><a href="../pages/index.php">Sobre nós</a></h3>
            </nav>
            <h3> &#169; Trouble Ticket FEUP</h3>
           </div>
    </footer>
    </body>
</html> <?php 
}

?>