<?php 
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/templates/common.php');
  $session = new Session();
  if($_SESSION['csrf'] != $_POST['csrf']) {
    drawAcessDenied();
    header('Location: ../pages/index.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
$db = getDatabaseConnection(); 
$agent = $_POST['agent'];
$department = $_POST['department'];

$user = User::getUserId($db, $agent);
$department_id = Department::getDepartmentId($department);

$db1 = getDatabaseConnection(); 
$stmt1 = $db1->prepare('SELECT * FROM agent where id = ? and department_id = ?');
$stmt1->execute(array($user->id, $department_id));
$agent_id = $stmt1->fetch();

if($agent_id) { 
  $session->addMessage('warning','Utilizador já estava atribuido a esse departamento');
    header('Location: ../pages/ticketmanage.php');
}

else {
$stmt = $db->prepare('INSERT INTO agent(id, department_id) VALUES (?, ?)');
$stmt->execute(array($user->id, $department_id));
$session->addMessage('success','Utilizador adicionado ao departamento');
header('Location: ../pages/ticketmanage.php');}
?>