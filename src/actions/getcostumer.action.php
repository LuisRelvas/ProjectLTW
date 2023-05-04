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

  echo("Tickets from department: ".$_GET['q']."<br>"); ?>
  <table>
  <tr>
    <th>Agent id</th>
    <th>Customer name</th>
    <th>Status</th>
    <th>Department id</th>
    <th>Ticket id</th>
  </tr>
  <?php foreach($department_id as $departments_id): ?>
    <tr>
      <td><?php echo $departments_id['agent_id']; ?></td>
      <td><?php echo $departments_id['username']; ?></td>
      <td><?php echo $departments_id['name']; ?></td>
      <td><?php echo $departments_id['department_id']; ?></td>
      <td><?php echo $departments_id['ticket_id']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>
    <?php
  unset($db); 

    $db = getDatabaseConnection();
  $stmt1 = $db->prepare( 'SELECT user.id,user.username from user,department,agent where user.id = agent.id and agent.department_id = department.department_id and department.name = ?');
  $stmt1->execute(array($_GET['q']));
  $department_agents = $stmt1->fetchAll();
  echo("<br>");
  echo("All the agents that belong to this department"."<br>");
  ?>
  <table>
  <tr>
    <th>Agent id</th>
    <th>Agent name</th>
  </tr>
  <?php foreach($department_agents as $departments_agents): ?>
    <tr>
      <td><?php echo $departments_agents['id']; ?></td>
      <td><?php echo $departments_agents['username']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

