<?php
require_once(dirname(__FILE__)."/../common.php");
ini_set( 'display_errors', 1 );

$params['source'] = isset($_POST['source'])?$_POST['source']:'';
$params['source_convert'] = '';

if($params['source'] != ''){
    //$tags = array("div","a","label","button","span","p","li","ul");
    
    //$len = mb_strlen($params['source']);
    
    $source_convert = preg_replace("/<(.*?)>/","asdasd<$1>", $params['source']);
    
    $exp = explode('asdasd', $source_convert);
    
    $tab_cnt = 0;
    foreach ($exp as $key => $html) {
        //upper case,lower case
        if(preg_match("/<img|<input|<br|<\/br/i", $html)){
            for ($i=0; $i < $tab_cnt; $i++) { 
                $html = " ".$html;
            }
        }else if(preg_match("/<\/(.*?)>/", $html)){
            $tab_cnt--;
            for ($i=0; $i < $tab_cnt; $i++) { 
                $html = " ".$html;
            }
        }else if(preg_match("/<(.*?)>/", $html)){
            for ($i=0; $i < $tab_cnt; $i++) { 
                $html = " ".$html;
            }
            $tab_cnt++;
        }
        $exp[$key] = $html;
    }
    
    $new = array();
    
    $e_cnt = count($exp);
    for ($i=0; $i < $e_cnt; $i++) { 
        if(isset($exp[($i+1)])){
            if(preg_match('/<\/(.*)>/', $exp[($i+1)],$match1)){
                if(isset($exp[$i]) && isset($match1[1]) && preg_match("/<{$match1[1]}(.*?)>/s", $exp[$i],$match2)){
                    $exp[$i].= "</{$match1[1]}>";
                    unset($exp[$i+1]);
                }
                
            }
        }
    }
    
    $params['source_convert'] = implode("\n", $exp);
}

$smarty->assign('language_list',Items::getLaguageList());
$smarty->assign('params',$params);
$smarty->assign('page_load_time',number_format((microtime(true) - $page_load_start_time),2)."s");


$smarty->display($tpl_name);
exit;
