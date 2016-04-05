<?php
require_once(dirname(__FILE__)."/../common.php");
ini_set( 'display_errors', 1 );

$params['type'] = isset($_POST['type'])?$_POST['type']:'decoding';
$params['source'] = isset($_POST['source'])?$_POST['source']:'';
$params['source_convert'] = '';

if($params['source'] != ''){
	if($params['type'] == 'decoding'){
		$params['source_convert'] = urldecode($params['source']);
	}else if($params['type'] == 'encoding'){
		$params['source_convert'] = urlencode($params['source']);
	}
}

$smarty->assign('type_list',Items::getTypeList());
$smarty->assign('params',$params);
$smarty->assign('page_load_time',number_format((microtime(true) - $page_load_start_time),2)."s");





$smarty->display($tpl_name);
exit;
