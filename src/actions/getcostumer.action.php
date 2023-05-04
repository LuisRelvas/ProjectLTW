<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session();
  $db = getDatabaseConnection(); 

  $stmt = $db->prepare( 'SELECT ticket.ticket_id,ticket.department_id,ticket.agent_id,user.username,status.name from department,ticket,user,status where status.status_id = ticket.status_id and department.department_id = ticket.department_id and user.id = ticket.id and department.name = ?');
  $stmt->execute(array($_GET['q']));
  $department_id = $stmt->fetchAll();

  echo("Tickets from department: ".$_GET['q']."<br>");
  foreach($department_id as $departments_id){
    echo("Agent id: ".$departments_id['agent_id']." ");
    echo("Costumer name: ".$departments_id['username']." ");
    echo("Status: ".$departments_id['name']." ");
    echo("Department id: ".$departments_id['department_id']." ");   
    echo("Ticket id: ".$departments_id['ticket_id']."<br>");
  }
  unset($db); 

    $db = getDatabaseConnection();
  $stmt1 = $db->prepare( 'SELECT user.username from user,department,agent where user.id = agent.id and agent.department_id = department.department_id and department.name = ?');
  $stmt1->execute(array($_GET['q']));
  $department_agents = $stmt1->fetchAll();
  echo("All the agents that belong to this department"."<br>");
  foreach($department_agents as $departments_agents){
    echo("Agent name: ".$departments_agents['username']."<br>");
  } 

?>
