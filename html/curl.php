<?php
require_once(dirname(__FILE__)."/../common.php");
ini_set( 'display_errors', 1 );

$params['url'] = isset($_POST['url'])?$_POST['url']:'';
$params['type'] = isset($_POST['type'])?$_POST['type']:'post';
$params['list'] = isset($_POST['list'])?$_POST['list']:array();
$html = '';

if((count($params['list']) > 1 || $params['type'] == 'get') && $params['url'] != ''){
	if($params['type'] == 'post'){
		$html = Items::curlPost($params['url'],$params['list']);
		
	}elseif($params['type'] == 'get'){
		$curl = curl_init();
		$options = array(
			CURLOPT_URL=> $params['url'],
			//CURLOPT_HEADER=> TRUE,
			CURLOPT_POST=> FALSE,
			CURLOPT_FOLLOWLOCATION=> TRUE,
			CURLOPT_RETURNTRANSFER=> TRUE,
		);
		
		curl_setopt_array($curl,$options);
		$html = curl_exec($curl);
		curl_close ($curl);
		
	}else{
	
	}
}

$smarty->assign('html',$html);
$smarty->assign('params',$params);
$smarty->assign('type_list',array('post','get'));

//$smarty->assign('params',$params);
$smarty->assign('page_load_time',number_format((microtime(true) - $page_load_start_time),2)."s");
$smarty->display($tpl_name);
exit;
