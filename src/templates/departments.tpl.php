<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/session.class.php'); 

function drawaddDepartment() { ?>
    <div id = "add-department">
    <form action="../actions/adddepartment.action.php" method ="post">
          <label>Nome Departamento: <input type="text" name="department_name" required="required" value="<?=$_SESSION['input']['department_name newUser']?>"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="button" type="submit" value="Adicionar Departamento">
      </form>
</div>
<?php
}
?>