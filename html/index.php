<?php
require_once(dirname(__FILE__)."/../common.php");
ini_set( 'display_errors', 1 );

$params['language'] = isset($_POST['language'])?$_POST['language']:'PHP';
$params['theme'] = isset($_POST['theme'])?$_POST['theme']:'Twilight';
$params['source'] = isset($_POST['source'])?$_POST['source']:'';
$params['source_convert'] = '';

if($params['source'] != ''){
	$url = 'http://markup.su/api/highlighter';
	$params['source_convert'] = Items::curlPost($url,$params);
}

$smarty->assign('language_list',Items::getLaguageList());
$smarty->assign('params',$params);
$smarty->assign('page_load_time',number_format((microtime(true) - $page_load_start_time),2)."s");


$smarty->display($tpl_name);
exit;
