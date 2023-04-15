<!DOCTYPE html>
<html lang="en-US">
<?php
  $db = new PDO('sqlite:trouble_ticket.db');
  $stmt = $db->prepare('SELECT * FROM user');
  $stmt->execute();
  $articles = $stmt->fetchAll();
?>
  <head>
    <title>Trouble Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aux.css">
</head>
<body>
    <header>
      <img src="/home/luisvrelvas/Documentos/project-ltw01g07/img/img1.jpg" alt="Example Image">
        <h1>Trouble Ticket FEUP</h1>
        <div id = "but">
          <form>
              <button formaction="login.php" formmethod="post" type="submit">
                Login
              </button>
              <button formaction="register.php" formmethod="post" type="submit">
                Register
              </button>
            </form>
            </div>
    </header>
    <div id="p1">
        <h2>O que é um trouble ticket ?</h2>
        <p>Um trouble ticket é um sistema que permite responder a dúvidas que o Cliente possa ter.</p>
        <p>Assim que o Cliente escolher o tópico da dúvida e a descrever, será atribuído um agente especializado nessa área que irá responder o mais brevemente possível.</p>
        <p>O Cliente terá acesso em tempo real ao estado do seu pedido.</p>
        <p>No final, poderá avaliar a qualidade do serviço.</p>
    </div>
    <div id="p2">
        <h2>Qual é o nosso principal objetivo?</h2>
        <p>O nosso principal objetivo é ajudar a faculdade a filtrar e resolver os problemas de forma eficiente.</p>
    </div>
    <div id="p3">
        <h2>FAQ</h2>
    </div>

    <div id="links">
        <h2>Links Úteis</h2>
        <nav>
        <ul>
            <li><a href="https://sigarra.up.pt/feup/pt/web_page.Inicial">Página Inicial Sigarra</a></li>
            <li><a href="https://www.up.pt/portal/pt/">Página Inicial UP</a></li>
        </ul></nav>
    </div>
</body>
</html>


