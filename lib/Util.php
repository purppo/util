<?php
class Util{
    private $_lib;

    public function __construct() {
    }
    
    public function __destruct(){
    }
    
    // 時刻 取得用
    public static function getNowDaytime($type = '') {
        $dateObj = new DateTime();
        if($type == 'datetime') {
            $type = "Y-m-d H:i:s";
        }elseif($type == 'date') {
            $type = "Y-m-d";
        }elseif($type == 'time') {
            $type = "H:i:s";
        }else{
            $type = "Y-m-d H:i:s";
        }
        $result = $dateObj->format($type);
        return $result;
    }
  
    // 人数
    public static function getPerson($max_person = 10) {
        $arr = array();
        for($i=1;$i<=$max_person;$i++){
            $arr[$i] = $i;
        }
        return $arr;
    }
    
    // 宿泊数
    public static function getStayCnt($max_stay = 10) {
        $arr = array();
        for($i=1;$i<=$max_stay;$i++){
            $arr[$i] = $i;
        }
        return $arr;
    }
    
    // 部屋数
    public static function getRoomCnt($max_room = 10) {
        $arr = array();
        for($i=1;$i<=$max_room;$i++){
            $arr[$i] = $i;
        }
        return $arr;
    }
    
    // 3年
    //get3Years->getAfterYears
    public static function getAfterYears($after_year = 3) {
        $dateObj = new DateTime();
        $now_year = $dateObj->format("Y");
        for($i=$now_year; $i<=$now_year+$after_year; $i++){
            $arr[$i] = sprintf("%02d",$i);
        }
        return $arr;
    }
    
    // 月
    public static function getMonths($start_month=1,$end_month=12) {
        for($i=$start_month; $i<=$end_month; $i++){
            $arr[$i] = sprintf("%02d",$i);
        }
        return $arr;
    }
    
    // 日
    public static function getDays($start_day=1,$end_day=31) {
        for($i=$start_day; $i<=$end_day; $i++){
            $arr[$i] = sprintf("%02d",$i);
        }
        return $arr;
    }
    
    // 時
    public static function getHours($start_hour=0,$end_hour=23) {
        for($i=$start_hour; $i<=$end_hour; $i++){
            $arr[$i] = sprintf("%02d",$i);
        }
        return $arr;
    }
    
    // 分
    public static function getMinutes($start_minute=0,$end_minute=59) {
        for($i=$start_minute; $i<=$end_minute; $i++){
            $arr[$i] = sprintf("%02d",$i);
        }
        return $arr;
    }
    
    //時間設定
    // getTime(00:00,00:00,3600)
    function getTime($start_time,$end_time,$second) {
        $time = array();
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);
        for ($i=$start_time; $i <= $end_time; $i+=$second) {
            $change_time = date("H:i",$i);
            $time[$change_time] = $change_time;
        }
        return $time;
    }
    
    //日付設定
    //例  :  getDate(date("Y-m-d"),7,"Y","m","d",'all',"jp");
    //例  :  getDate(date("Y-m-d",7,7,"Y","m","d",'month',"jp");
    function getDate($start_day,$plusAndminus_num,$year_type,$month_type,$day_type,$type='all',$lg="") {
        $time = array();
        $start_time = strtotime($start_day);
        $end_time = strtotime($plusAndminus_num." day", $start_time);
        for ($i=$start_time; $i <= $end_time; $i+=86400) {
            $key = date($year_type."-".$month_type."-".$day_type,$i);
            $val = $key; 
            if($type == 'all'){
                if($lg == 'jp'){
                    $val = date($year_type."年".$month_type."月".$day_type."日",$i);
                }
            }else if($type == 'month'){
                if($lg == 'jp'){
                    $val = date($month_type."月".$day_type."日",$i);
                }else{
                    $val = date($month_type."-".$day_type,$i);
                }
            }
            $time[$key] = $val;
        }
        return $time;
    }
    
    function getDateList($start_day,$end_day) {
        $diff = self::getDateFromToDiff($start_day,$end_day);
        $time = array();
        for ($i=0; $i <=$diff; $i++) { 
            $val = date('Y-m-d',strtotime($start_day." $i day"));
            $date_list[$i] = $val;
        }
        return $date_list;
    }
    
    //日付の差を求める
    function getDateFromToDiff($date_from,$date_to) {
        return (strtotime($date_to) - strtotime($date_from)) / ( 60 * 60 * 24);
    }
    
    //月の差を求める
    function getMonthDateFromToDiff($date_from,$date_to) {
        return (int)floor((strtotime($date_to) - strtotime($date_from)) / ( 60 * 60 * 24 * 28));
    }
    
    // 祝日取得
    //tpye = > japanese__ja,
    public function getHolidays($start_day,$end_day,$code = "jp"){
        $arr = array();
        if($code == 'jp'){
            $code = 'japanese__ja';
        }else if($code == 'en'){
            $code = 'usa__en';
        }
        $url = 'https://www.google.com/calendar/feeds/'.$code.'%40holiday.calendar.google.com/public/basic?';
        $url.= "start-min=$start_day&start-max=$end_day&max-results=730&alt=json";
    
        $results = json_decode(file_get_contents($url), true);
    
        //年月日（例：20120512）をキーに、祝日名を配列に格納
        if(isset($results['feed']['entry'])){
            foreach ($results['feed']['entry'] as $value) {
                $date = preg_replace('#\A.*?(2\d{7})[^/]*\z#i', '$1', $value['id']['$t']);
                $date = date("Y-m-d",strtotime($date));
                //$title = $value['title']['$t'];
                //$holidays[$date] = $title;
                $arr[$date] = $date;
            }
            //祝日の配列を早い順に並び替え
            ksort($arr);
        }
        return $arr;
    }
    
    /**
    *    渡された日付の前後日を返す
    *    @param type $days
    *    @param type $plusAndminus_num
    *    @return ARRAY
    */
    public function getBeforeAfterdays($days=array(),$plusAndminus_num){
        $arr = array();
        foreach ($days as $key => $val) {
            $change = date("Y-m-d",strtotime($key." ".$plusAndminus_num." day"));
            $arr[$change] = $change;
        }
        
        return $arr;
    }
    
    /**
    *    第1引数に配列を入れて呼べばhiddenタグを作って返す（何階層もの連想配列でも可）
    *    @param type $arr
    *    @param type $no_params
    *    @param type $keys
    *    @param type $return
    *    @return string
    */
    function createHiddenByArr($arr,$no_params=array(),$keys = array(),$return = ''){
        foreach($arr AS $key => $val){
            if(in_array($key,$no_params)){
                continue;
            }
            $sets = array_merge($keys,array($key));
            if(is_array($val)){
                $return = self::createHiddenByArr($val,$no_params,$sets,$return);
            }else{
                $return .= "<input type='hidden' name='";
                for($i=0,$max=count($sets);$i<$max;++$i){
                    if($i == 0){
                        $return .= "".$sets[$i]."";
                    }else{
                        $return .= "[".$sets[$i]."]";
                    }
                }
                $return .= "' value='". htmlspecialchars($val)."'>";
            }
        }
        return $return;
    }
    
    public static function getLimitCountUp($start_limit = 0,$end_limit = 20,$plus = 1) {
        $arr = array();
        for($i=$start_limit; $i<=$end_limit; $i+=$plus){
            $arr[$i] = $i;
        }
        return $arr;
    }
    
    
    public static function sendErrMail($body) {
        
        //mb_language("uni");
        //mb_language("Japanese");
        //mb_internal_encoding("UTF-8");
        
        $to = 'sangjun@psinc.jp';
        $to.= ',leedaebum@psinc.jp';
        //$to.= ',hasegawa@psinc.jp';
        
        $subject = "RCRuleEngine SQL ERROR";
        
        $headers = "From: ".mb_encode_mimeheader("Rule System")."<RCRuleSys@psinc.jp>\r\n";
        $headers.= "Return-path: RCRuleSys@psinc.jp>\r\n";
        $headers.= "Content-Type: text/plain; charset=UTF-8\r\n";
        return mail($to,$subject,$body,$headers);
    }
    
    public static function sendMail($body,$mail_name='',$from='',$to='',$cc='',$bcc='',$subject='') {
        
        //mb_language("uni");
        //mb_language("Japanese");
        //mb_internal_encoding("UTF-8");
        
        
        mb_language("uni");
        mb_internal_encoding('UTF-8');
        //mb_language("Japanese");
        //mb_internal_encoding("UTF-8");
        
        if($to == ''){
            $to = 'sangjun@psinc.jp';
            $to.= ',leedaebum@psinc.jp';
        }
        
        if($from == ''){
            $from = 'rule_engin@psinc.jp';
        }
        
        if($subject == ''){
            $subject = "RCRuleEngine SQL ERROR";
        }
        
        if($subject == ''){
            $subject = "RCRuleEngine SQL ERROR";
        }
        
        if($mail_name == ''){
            $mail_name = 'Rule-Engine';
        }
        
        $headers  = '';
        $headers .= 'From: '.mb_encode_mimeheader($mail_name).'<'.$from .'>'. "\r\n" ;
        $headers .= 'Return-path: '.$from . "\r\n" ;
        if($cc != ''){
            $headers .= 'Cc: '.$cc . "\r\n";
        }
        if($bcc != ''){
            $headers .= 'Bcc: '.$bcc . "\r\n";
        }
        
        //余計な改行を削除
        $body = str_replace("\r","",$body);
        
        return mb_send_mail($to , $subject , $body,$headers);
        
    }
    
    
    //GET形式のURL生成
    public static function createParametarURL($data){
        $url_arr = array();
        foreach ($data as $key => $val) {
            $url_arr[] = $key." = '".$val."'";
        };
        
        $url.= implode("&", $url_arr);
        return $url;
    }
    
    //secure->クライアントからのセキュアな HTTPS 接続の場合にのみクッキーが送信されるようにします。 TRUE を設定すると、セキュアな接続が存在する場合にのみクッキーを設定します。
    //httponly->TRUE を設定すると、HTTP を通してのみクッキーにアクセスできるようになります。 つまり、JavaScript のようなスクリプト言語からはアクセスできなくなるということです。
    //例  : createCookie($param,3600,$lib->getConfig()->domain,1,1))
    public static function createCookie($data,$second=3600,$domain='',$secure=1,$httponly=1){
        $setting = Setting::setSetting();
        if($domain == '')$domain = $setting['conf']['domain'];
        $time = time();
        foreach ($data as $key => $val) {
            if(!setcookie  (  $key  , $val  , $time+$second , "/"  , $domain  , $secure  , $httponly   )){
                return FALSE;
            }
        }
        return TRUE;
        
    }
    
    public static function deleteCookie($data,$second=3600,$domain='',$secure=1,$httponly=1){
        $setting = Setting::setSetting();
        if($domain == '')$domain = $setting['conf']['domain'];
        $time = time();
        foreach ($data as $key => $val) {
            if(!setcookie  (  $key  , $val  , ($time-$second) , "/"  , $domain  , $secure  , $httponly   )){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    public static function createSession($data){
        //session check
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        foreach ($data as $key => $val) {
            $_SESSION[$key] = $val;
        }
        return TRUE;
    }
    
    public static function deleteSession($data = array()){
        if(count($data) > 0){
            foreach ($data as $key => $val) {
                session_unset($key);
            }
        }else{
            //全部削除
            session_unset();
        }
        
        
        return TRUE;
    }
    
    //cookieが存在するかどうかをチェック
    public static function isCookie($data){
        foreach ($data as $key => $val) {
            if(!isset($_COOKIE[$key])){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    //sesstionの存在するかどうかをチェック
    public static function isSession($data){
        foreach ($data as $key => $val) {
            if(!isset($_SESSION[$key])){
                return FALSE;
            }
        }
        
        return TRUE;
    }
    
    //cookieと渡されたデータが同じなのかチェック
    public static function checkCookie($data){
        foreach ($data as $key => $val) {
            if(!isset($_COOKIE[$key]) || $_COOKIE[$key] != $val){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    //sesstionと渡されたデータが同じなのかチェック
    public static function checkSession($data){
        foreach ($data as $key => $val) {
            if(!isset($_SESSION[$key]) || $_SESSION[$key] != $val){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    //cookieを取得
    public static function getCookie($data = array()){
        
        $res = array();
        if(count($data) > 0){
            foreach ($data as $key => $val) {
                if(isset($_COOKIE[$key])){
                    $res[$key] = $_COOKIE[$key];
                }
            }
        }else{
            //全て取得
            if(count($_COOKIE) != 0){
                foreach ($_COOKIE as $key => $val) {
                    $res[$key] = $val;
                }
            }
        }
        
        
        return $res;
    }
    
    //sesstionを取得
    public static function getSession($data = array()){
        
        $res = array();
        if(count($data) > 0){
            foreach ($data as $key => $val) {
                if(isset($_SESSION[$key])){
                    $res[$key] = $_SESSION[$key];
                }
            }
        }else{
            //全て取得
            if(count($_SESSION) != 0){
                foreach ($_SESSION as $key => $val) {
                    $res[$key] = $val;
                }
            }
        }
        
        return $res;
    }
    
    
    //REFERER Check
    //例:RCBookingEngineItems::checkReferer($_SERVER["SCRIPT_NAME"])
    public static function checkReferer($before_url){
        if(isset($_SERVER['HTTP_REFERER']) && preg_match("/".preg_quote($before_url,"/")."/", $_SERVER['HTTP_REFERER'])){
            return TRUE;
        }
        return FALSE;
    }
    
    
    /**
    *    POST,GETをに入れて返す
    *    @param type $param
    *    @return ARRAY
    *    例:$param = RCBookingEngineItems::setParam($param);
    */
    public static function setParam($param = array()){
        foreach ($param as $key => $val) {
            if(isset($_REQUEST[$key])){
                $param[$key] = $_REQUEST[$key];
            }
        }
        return $param;
    }
    
    //obj -> arr切り替える
    public static function obj2arr($obj){
        if ( !is_object($obj) ) return $obj;

        $arr = (array) $obj;
        
        foreach ( $arr as &$a ){
            $a = self::obj2arr($a);
        }
        return $arr;
    }
    
    //calendar
    public static function getCalendar($year,$month){
        $start_date = date($year."-".$month."-01");
        $end_date = date($year."-".$month."-t");
        
        
        $start_week = date("N",strtotime($start_date))-1;
        $end_week = (7-date("N",strtotime($end_date)));
        
        $start_date = date("Y-m-d", strtotime($start_date." -".$start_week." day"));
        $end_date = date("Y-m-d", strtotime($end_date." +".$end_week." day"));
        
        $diff_cnt = self::getDateFromToDiff($start_date,$end_date);
        $date_arr = self::getDate($start_date,$diff_cnt,'Y','m','d');
        $cnt = 0;
        $num = 0;
        $calendar = array();
        foreach ($date_arr as $key => $val) {
            if($num % 7 == 0){
                $cnt++;
            }
            $calendar[$cnt][$val] = $val;
            $num++;
        }
        
        return $calendar;
    }
    
    // 表示件数○○○～○○○
    public function getDispCntFromTo($params,$max_cnt=0) {
        $arr = array();
        $arr['from'] = $params['showcnt']*($params['page']-1)+1;
        $arr['to'] = ($params['showcnt']*($params['page']-1))+$params['showcnt'];
        if($max_cnt == 0){
            $arr['from'] = 0;
        }
        if($arr['to'] > $max_cnt){
           $arr['to'] = $max_cnt;
        }
        //echo "<pre>";var_dump($params);echo "</pre>";
        return $arr;
    }
    
    public function getPagerDataCut($list,$params) {
        $list = array_slice($list,(($params['page']-1) * $params['showcnt']),$params['showcnt']);
        return $list;
    }
    
     // ページャー作成
    public function getPager($params,$max_cnt) {
        
        $show_cnt = $params['showcnt'];
        $cut_cnt = $params['cutcnt'];
        
        $last_page = ceil($max_cnt / $show_cnt);
        
        $before_group = false;
        $next_group = false;
        //最小の番号を取得
        if($params['page'] > $cut_cnt + 1 ){
            $start_page = $params['page'] - $cut_cnt;
            $before_group = true;
        }else{
            $start_page = 1;
        }
        
        //最大番号取得
        if($params['page'] + $cut_cnt < $last_page ){
            $end_page = $params['page'] + $cut_cnt;
            $next_group = true;
        }else{
            $end_page = $last_page;
        }
        
        $arr = array();
        for($i=$start_page;$i<=$end_page;++$i){
            $k = $i;
            if($i == $start_page && $before_group){
                $j = $k -1;
                $arr[] = $k;
            }elseif($i == $end_page && $next_group){
                $j = $k + 1;
                $arr[] = $k;
            }else{
                $arr[] = $k;
            }
        }
        return $arr;
    }

// パラメーター生成
    public function setParameter($params,$no_params=array()) {
        $url_arr = array();
        foreach($params AS $key => $val){
            if(is_array($val) && !in_array($key,$no_params)){
                foreach($val AS $kkey => $vval){
                    $url_arr[] = $key."[]=".$vval;
                }
            }else{
                if($val != '' && !in_array($key,$no_params)){
                    $url_arr[] = $key."=".$val;
                }
            }
        }
        return implode("&",$url_arr);
    }
    
    // hiddenパラメーター生成
    public function setHiddenParameter($params,$no_params=array()) {
        $hidden_url_arr = array();
        foreach($params AS $key => $val){
            if(is_array($val) && !in_array($key,$no_params)){
                foreach($val AS $kkey => $vval){
                    $hidden_url_arr[$key.'[]'] = $vval;
                }
            }else{
                if(!in_array($key,$no_params)){
                    $hidden_url_arr[$key] = $val;
                }
            }
            
            if(!in_array($key,$no_params)){
                $hidden_url_arr[$key] = $val;
            }
        }
        return $hidden_url_arr;
    }
    
    
    public static function curlPost($url,$data){
        $q = http_build_query($data);
        $curl = curl_init();
        //?language=PHP&source=%22%3C?php&theme=Twilight
        $options = array(
            CURLOPT_URL=> $url,
            CURLOPT_POST=> TRUE,
            //CURLOPT_COOKIEJAR=> $this->cookie_dir."cookie",
            //CURLOPT_COOKIEFILE=> $this->cookie_dir."cookie",
            //CURLOPT_HEADER=> TRUE,
            CURLOPT_FOLLOWLOCATION=> TRUE,
            CURLOPT_POSTFIELDS=>$q,
            CURLOPT_RETURNTRANSFER=> TRUE,
            //プロキシ経由フラグ
            //CURLOPT_PROXY=> $this->proxy_ip, //IP指定
            //CURLOPT_PROXYPORT=>$this->proxy_port, //ポート指定
            //CURLOPT_WRITEHEADER=> $fp,
        );
        
        curl_setopt_array($curl,$options);
        
        $head = curl_exec($curl);
        curl_close ($curl);
        
        return $head;
    }
    

}
