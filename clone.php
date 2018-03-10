<?php
function bacaURL($url){
$session = curl_init();
curl_setopt($session, CURLOPT_URL, $url);
curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
$hasil = curl_exec($session);
curl_close($session);
return $hasil;
}

if(isset($_GET['kode'])){
$kode = $_GET['kode'];

$sumberasli = bacaURL('http://propana.otoreport.com/harga.js.php?prd='.$kode.'&up=44444100');
$sumber2 = str_replace('<tr class="td2">','<tr>', $sumberasli);
$sumberfix = str_replace('<tr class="td1">','<tr>', $sumber2);
$list = array();
$ambil_kata = explode('<div class="tablewrapper">', $sumberfix);
$ambil_kata_lagi = array_filter(explode('</tr>', str_replace('<tr>','',$ambil_kata[1])));
unset($ambil_kata_lagi[count($ambil_kata_lagi)-1]);

// &lt;/table&gt;
//&lt;/div&gt;

$i=2;

while($i <= count($ambil_kata_lagi)-1){

$a = htmlentities($ambil_kata_lagi[$i]);


$search = array(
'&lt;',
'&gt;',
'/',
'td',
'class=&quot;center&quot;',
'tr class=&quot;1&quot;',
'class=&quot;center last&quot;',
'span class=&quot;green&quot;',
'span',
'\n',
'tr class=&quot;2&quot;',
'&lt;/table&gt;',
'&lt;/div&gt;',
'&lt;br /&gt;',
'div',
'&lt;/td&gt;',
'&lt;/tr&gt;',
'table'
);

$modifiedString = str_replace($search, "", $a);
$pecahan = explode("\n ", $modifiedString);

$harga = array("kode" => "$pecahan[2]", "nama" => "$pecahan[3]", "harga" => "$pecahan[4]", "status" => "$pecahan[6]");
array_push($list, $harga);
$i++;
}

$json = json_encode($list);
print($json);

} 
?>