<?php 
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session();
$db = getDatabaseConnection(); 
$agent = $_POST['agent'];

$department = $_POST['department'];


$user = User::getUserId($db, $agent);

$department_id = Department::getDepartmentId($department);
 
$stmt1 = $db->prepare('SELECT * FROM agent where id = ? and department_id = ?');
$stmt1->execute(array($user->id, $department_id));
$agent_id = $stmt1->fetch();

if($agent_id) {
    $stmt = $db->prepare('DELETE FROM agent WHERE id = ? and department_id = ?');
    $stmt->execute(array($user->id, $department_id));
    $session->addMessage('success','Utilizador removido com sucesso');
    header('Location: ../pages/ticketmanage.php');
}
else if(!$agent_id){
    $session->addMessage('warning','Utilizador já não estava atribuido a esse departamento');
    header('Location: ../pages/ticketmanage.php');}
?>