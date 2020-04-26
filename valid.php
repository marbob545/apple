<?php 

error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Jakarta');
$v_date = date("dmy");
$banner = '

-==================================================-
 ___    ____  _   ____  _____      _    ____     _____
|  _ ) / ___/ _ \|  _ \| ____|   / _ \ |  _  \  / ____|
|  _ \| |  | | | | | | |  _|    | | | ||  _  / | | ___
| |_) | |__| |_| | |_| | |___   | |_| || | \ \ | ||__ |
|____/ \____\___/|____/|_____(_) \___/ |_|  \_\ \_____/

// Baperc0de - Meski Baper Anti Mager.
// Valid Apple V.1
// CODE BY Baperc0de
// fahmi@baperc0de.org

-==================================================-
';


$get=file_get_contents($argv[1])
or die("
\n\tError !
\n\tusage => php valid.php yourlist.txt\n\n");
print $banner;
$j=explode("\r\n",$get);
$total = count($j);
$i = 1;
$info = "Nama List : ".$argv[1]."\n";
print $info;
$kontol =  "Total List : ".$total."\n";
print $kontol;

for ($i = 1; $i < $total; ++$i) {
foreach($j as $email){
	
print "\n\t";
$getdata = json_decode(file_get_contents("https://priv8.bukancoder.co/apple/check.php?email=".$email.""));
$data  = $getdata->error_code;
$mailist  = $getdata->status;
$email  = $getdata->email;
if($data == "0"){
$fp = fopen("Apple-result.txt", "a");
fputs($fp, "$mailist ==> $email \r\n");
fclose($fp);
} else if($status == "209"){
$hasil = "INVALID";
} else {
$hasil = "INVALID";
}
echo '| '.++$i.' dari '.$total.' | '.date("H:i:s").' | '.$mailist.' ==> '.$email.' | "Checked by : Baperc0de | AppleValid V.1" | ';
}
}

print "\n
Done for Checking !
Result Live Save in Apple-result.txt
Buy for a fast checking 
PM Me On Facebook : Fahmi V Squad

-===========[Baperc0de - Valid Apple v.1]===========--
";
?>
