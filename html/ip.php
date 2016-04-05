<?php
require_once(dirname(__FILE__)."/../common.php");
ini_set( 'display_errors', 1 );


$params['ip'] = $_SERVER['REMOTE_ADDR'];
$smarty->assign('params',$params);
$smarty->assign('page_load_time',number_format((microtime(true) - $page_load_start_time),2)."s");





$smarty->display($tpl_name);
exit;
