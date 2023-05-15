<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php'); 
require_once(dirname(__DIR__).'/templates/departments.tpl.php');
require_once(dirname(__DIR__).'/classes/hashtag.class.php'); 

$session = new Session();



drawHeader($session);
if($_SESSION['role'] != 0 ) { 
    drawAcessDenied();
}
else { 
drawllHashtags();
drawallDepartments();
drawallStatus();
drawTicketSearch();
drawaddDepartment();
drawaddHashtags();
drawaddFaq();
addAgentDepartment();}
drawFooter();

