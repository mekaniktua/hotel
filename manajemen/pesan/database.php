<?php
if($_SERVER['HTTP_HOST']!='kapsterbox.com'){
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "rootPassword123";//newrootpassword
	$dbname = "db_kapsterbox"; 
}else{
	$dbhost = "localhost";
	// $dbuser = "duniascr_hantaru2022";
	// $dbpass = "hantaru2022password123";
	$dbuser = "duniascr_u_kaps";
	$dbpass = "kapsterbox1234";
	$dbname = "duniascr_kapsterbox";
}
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

function umur($x){
	$birthDate = explode("/", $x);
      //get age from date or birthdate
      $umur = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));
      return $umur;
}
function jarak($x){
	if($x>0){
		$jarak = number_format(($x/1000),2,",","."); 

	}else{
		$jarak=0;
	}
	return $jarak;
}

 

function waktu($x){ 
	// $minsec = gmdate("i:s", $x);    
	// $hours = (gmdate("d", $x)-1)*24 + gmdate("H", $x);    
	// $waktu = $hours.':'.$minsec;
	$date = $x; 
	$seconds_per_minute = 60;
	$seconds_per_hour = 3600;
	 
	$hours = floor($date / $seconds_per_hour);
	$date = $date - ($hours * $seconds_per_hour);
	$minutes = floor($date / $seconds_per_minute);
	$date = $date - ($minutes * $seconds_per_minute);
	$seconds = floor($date);
	if($hours<10){
		$hours="0".$hours;
	}
	if($minutes<10){
		$minutes="0".$minutes;
	}
	if($seconds<10){
		$seconds="0".$seconds;
	}
	$waktu = $hours.':'.$minutes.':'.$seconds;
	return $waktu;
}

function waktuMenit($x){ 
	$minsec = gmdate("i:s", $x);    
	$hours = (gmdate("d", $x)-1)*24 + gmdate("H", $x);    
	$waktu = $minsec;
	return $waktu;
}

function indoTanggal($x){
	if (substr($x,5,2)=='01'){
		$bulanJam = substr($x,8,2)." "."Januari " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='02'){
		$bulanJam = substr($x,8,2)." "."Februari " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='03'){
		$bulanJam = substr($x,8,2)." "."Maret " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='04'){
		$bulanJam = substr($x,8,2)." "."April " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='05'){
		$bulanJam = substr($x,8,2)." "."Mei " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='06'){
		$bulanJam = substr($x,8,2)." "."Juni " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='07'){
		$bulanJam = substr($x,8,2)." "."Juli " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='08'){
		$bulanJam = substr($x,8,2)." "."Agustus " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='09'){
		$bulanJam = substr($x,8,2)." "."September " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='10'){
		$bulanJam = substr($x,8,2)." "."Oktober " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='11'){
		$bulanJam = substr($x,8,2)." "."November " . substr($x,0,4) . substr($x,10);
	}if (substr($x,5,2)=='12'){
		$bulanJam = substr($x,8,2)." "."Desember " . substr($x,0,4) . substr($x,10);
	}
	
	return $bulanJam; 
}
function normalTanggal($x){
	return substr($x,8,2)."/".substr($x,5,2)."/".substr($x,0,4); 
}
function normalTanggalJam($x){
	return substr($x,8,2)."/".substr($x,5,2)."/".substr($x,0,4). substr($x,10); 
}

function tanggalOnly($x){
	return substr($x,0,4)."/".substr($x,5,2)."/".substr($x,8,2); 
}

function databaseTanggal($x){
	return substr($x,6,4)."-".substr($x,3,2)."-".substr($x,0,2) ; 
}
function databaseTanggalJam($x){
	return substr($x,6,4)."-".substr($x,3,2)."-".substr($x,0,2).substr($x,10); 
}
function bulanRomawi($x){
	if (substr($x,5,2)=='01'){
		$bulanRomawi = "I";
	}if (substr($x,5,2)=='02'){
		$bulanRomawi = "II";
	}if (substr($x,5,2)=='03'){
		$bulanRomawi = "III";
	}if (substr($x,5,2)=='04'){
		$bulanRomawi = "IV";
	}if (substr($x,5,2)=='05'){
		$bulanRomawi = "V";
	}if (substr($x,5,2)=='06'){
		$bulanRomawi = "VI";
	}if (substr($x,5,2)=='07'){
		$bulanRomawi = "VII";
	}if (substr($x,5,2)=='08'){
		$bulanRomawi = "VIII";
	}if (substr($x,5,2)=='09'){
		$bulanRomawi = "IX";
	}if (substr($x,5,2)=='10'){
		$bulanRomawi = "X";
	}if (substr($x,5,2)=='11'){
		$bulanRomawi = "XI";
	}if (substr($x,5,2)=='12'){
		$bulanRomawi = "XII";
	}
	
	return $bulanRomawi; 
}

function amankan($x) {
	$search  = array('SELECT', ' UNION ', ' AND ', ' OR ');
    $replace = array('', '', '', '', '');
	
	$kataAman = strip_tags(trim($x));
	$kataAman = str_replace("'","",$kataAman);
	$kataAman = str_replace("--","",$kataAman);
	$kataAman = str_replace(";","",$kataAman);
	$kataAman = str_ireplace($search,$replace,$kataAman); 
	 
	return $kataAman;
}
function angka($x){
	$angka=str_replace(",",".",number_format($x));
	return $angka;
}
function angkaKoma($x){
	$angka=str_replace(".",",",number_format($x,2));
	return $angka;
}
function ganti($x) {
	$ganti = strip_tags($x);
	$ganti = str_replace("/","_",$ganti);
	$ganti = str_replace("+","_",$ganti);
	$ganti = str_replace("'","",$ganti); 
	 
	return $ganti;
}

#Terbilang
function terbilang($bilangan){
 $bilangan = abs($bilangan);
 
$angka = array("Nol","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
 $temp = "";
 
if($bilangan < 12){
 $temp = " ".$angka[$bilangan];
 }else if($bilangan < 20){
 $temp = terbilang($bilangan - 10)." belas";
 }else if($bilangan < 100){
 $temp = terbilang($bilangan/10)." puluh".terbilang($bilangan%10);
 }else if ($bilangan < 200) {
 $temp = " seratus".terbilang($bilangan - 100);
 }else if ($bilangan < 1000) {
 $temp = terbilang($bilangan/100). " ratus". terbilang($bilangan % 100);
 }else if ($bilangan < 2000) {
 $temp = " seribu". terbilang($bilangan - 1000);
 }else if ($bilangan < 1000000) {
 $temp = terbilang($bilangan/1000)." ribu". terbilang($bilangan % 1000);
 }else if ($bilangan < 1000000000) {
 $temp = terbilang($bilangan/1000000)." juta". terbilang($bilangan % 1000000);
 }
 
return trim($temp);
}

function listArray($x){
	if($x !=''){
		$arrayList	= $x;
		$g=1;
		$list = "";
		foreach($arrayList as $idList)
		{
		  $list .= $idList.",";
		  $g +=1;
		
		}  
		$hasil = trim($list,",");
	 return $hasil;
	}
}
 
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



function namaBulan($x){
	if ($x=='01'){
		$bulan = "Januari ";
	}if ($x=='02'){
		$bulan = "Februari ";
	}if ($x=='03'){
		$bulan = "Maret ";
	}if ($x=='04'){
		$bulan = "April ";
	}if ($x=='05'){
		$bulan = "Mei ";
	}if ($x=='06'){
		$bulan = "Juni ";
	}if ($x=='07'){
		$bulan = "Juli ";
	}if ($x=='08'){
		$bulan = "Agustus ";
	}if ($x=='09'){
		$bulan = "September ";
	}if ($x=='10'){
		$bulan = "Oktober ";
	}if ($x=='11'){
		$bulan = "November ";
	}if ($x=='12'){
		$bulan = "Desember ";
	}
	
	return $bulan; 
}


// Fungsi Membuat Titik (Ribuan)
function titik($data)
{
$titik = "";
$jml = strlen($data);

while($jml > 3)
{
$titik = "." . substr($data,-3) . $titik;
$l = strlen($data) - 3;
$data = substr($data,0,$l);
$jml = strlen($data);
}
$titik = $data . $titik;
return $titik;
} 

// Fungsi Membuat Titik (Ribuan)
function titikKoma($data)
{
$titik = "";
$iData = explode(",",$data);
echo $iData;
$jml = strlen($data);

while($jml > 3)
{
$titik = "." . substr($data,-3) . $titik;
$l = strlen($data) - 3;
$data = substr($data,0,$l);
$jml = strlen($data);
}
$titik = $data . $titik;
return $titik;
} 

function enkripsi($text)
{
   if($text !=''){ 
		$encrypt_method = "AES-256-CBC";
	    $secret_key = 'kapsterbx';
	    $secret_iv = 'versi1';

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16); 
	    $output = openssl_encrypt($text, $encrypt_method, $key, 0, $iv); 
	    return $output; 
   }else{
		return "";
	}
}

function dekripsi($text)
{
    if($text !=''){
		$text = tambah($text);
		$encrypt_method = "AES-256-CBC";
	    $secret_key = 'kapsterbx';
	    $secret_iv = 'versi1';

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16); 
	    $output = openssl_decrypt($text, $encrypt_method, $key, 0, $iv); 
		return tambah($output);
	}else{
		return "";
	}
}

function randomText($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
} 

function tambah($text){
	return str_replace(" ","+",$text);	
}

error_reporting(E_ALL & ~E_NOTICE);

 

//Set Client ID
  
//error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Jakarta');

//Setting Hari ini;
//define("HARI_INI","2021-01-01");
define("HARI_INI",date("Y-m-d"));

define("API_KEY", "6111E82AA9D2EB3C328BA70B405A9C8C");
function kirimWA($api_key, $isiWA, $nomor_hp)
{
	$baseURL = "https://api.nusasms.com/nusasms_api/1.0/whatsapp/message";
	if (substr($nomor_hp, 0, 1) == "0") {
		$nomor_hp = "62" . substr($nomor_hp, 1);
	}
	$curl = curl_init();
	$payload = json_encode(array(
		'destination' => $nomor_hp,
		'message' => $isiWA
	));
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $baseURL,
		CURLOPT_POST => true,
		CURLOPT_HTTPHEADER => array(
			"APIKey: " . $api_key,
			'Content-Type:application/json'
		),
		CURLOPT_POSTFIELDS => $payload,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
		CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2
	));

	$resp = curl_exec($curl);

	if (!$resp) {
		$error_status = curl_error($curl);
		$error_code = curl_errno($curl);
	} else {
		$arr = json_decode($resp, true);

		$detail = $arr['detail'];
		$error_status = $arr['error'];
		$error_code = $arr['error_code'];
		$message = $arr['message'];
		$ref_no = $arr['data']['ref_no'];
	}
	curl_close($curl);;
	$kirimWA = array("baseURL" => $baseURL, "detail" => $detail, "error_status" => $error_status, "error_code" => $error_code, "message" => $message, "ref_no" => $ref_no, "nomor_hp" => $nomor_hp, "isi_wa" => $isiWA);
	return $kirimWA;
}
?>