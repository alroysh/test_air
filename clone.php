<?php
 if(isset($_GET['kode'])){
  $kode = $_GET['kode'];
 }
 if(isset($_GET['up'])){
  $up = $_GET['up'];
 }else{
  $up = 0;
 }
    function bacaURL($url){
      $session = curl_init();
      curl_setopt($session, CURLOPT_URL, $url);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
      $hasil = curl_exec($session);
      curl_close($session);
         return $hasil;
    }




 if(isset($_GET['kode'])){
 
      $sumberasli =  bacaURL('http://propana.otoreport.com/harga.js.php?prd='.$_GET['kode'].'&up='.$up);
      $sumber2 = str_replace('<tr class="td2">','<tr>', $sumberasli);
   $sumberfix = str_replace('<tr class="td1">','<tr>', $sumber2);
     $list = array();
  $daftar = array();
      $ambil_kata = explode('<div class="tablewrapper">', $sumberfix);
   $ambil_kata_lagi = array_filter(explode('</tr>', str_replace('<tr>','',$ambil_kata[1])));
   unset($ambil_kata_lagi[count($ambil_kata_lagi)-1]);

//                &lt;/table&gt;
                //&lt;/div&gt;
    
   $i=2;
   $nomor=1;
   $aa = 1;
      while($i <= count($ambil_kata_lagi)-1){
        
  $a = htmlentities($ambil_kata_lagi[$i]); 
  $b = htmlentities($ambil_kata_lagi[0]); 


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
         'table',
    'class=&quot;tabel&quot;
            tr class=&quot;head&quot;
             col=&quot;6&quot;  style=&quot;background-color: #4784a5;&quot;'
        );
        
        $modifiedString = str_replace($search, "", $a);
  $judul = str_replace($search, "", $b);
  $pecahan = explode("\n", $modifiedString);
  $pecahan2 = explode("\n", $judul);
  $ljudul= ltrim($pecahan2[1]," ");
  $lkode= ltrim($pecahan[2]," ");
  $lnama= ltrim($pecahan[3]," ");
  $lharga= ltrim($pecahan[4]," ");
  $lstatus= ltrim($pecahan[6]," ");
  $harga = array("kode" => "$lkode", "nama" => "$lnama", "harga" => "$lharga", "status" => "$lstatus");
  $kodenya = $harga['kode'];
  $list[$aa++] = $harga;
  $nomor++;
  $i++;
      }
  $daftar[1] = array("judul" => $ljudul, "detail" => $list);
  $json = json_encode($daftar[1]);
  print($json);
   }else{
   
   $sumberasli =  bacaURL('http://propana.otoreport.com/harga.js.php?up='.$up);
      $sumber2 = str_replace('<tr class="td2">','<tr>', $sumberasli);
   $sumberfix = str_replace('<tr class="td1">','<tr>', $sumber2);
      $ambil_kata = explode('<div class="tablewrapper">', $sumberfix);
   $daftar = array();
   $nomor2=1;
   while($nomor2 <= count($ambil_kata)-1){
    $list = array();
    $ambil_kata_lagi = array_filter(explode('</tr>', str_replace('<tr>','',$ambil_kata[$nomor2])));
    unset($ambil_kata_lagi[count($ambil_kata_lagi)-1]);

 //                &lt;/table&gt;
     //&lt;/div&gt;
  
    $i=2;
    $nomor=1;
    while($i <= count($ambil_kata_lagi)-1){
   
   $a = htmlentities($ambil_kata_lagi[$i]);
   $b = htmlentities($ambil_kata_lagi[0]); 


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
    'table',
    'class=&quot;tabel&quot;
            tr class=&quot;head&quot;
             col=&quot;6&quot;  style=&quot;background-color: #4784a5;&quot;'
   );
   
   $modifiedString = str_replace($search, "", $a);
   $judul = str_replace($search, "", $b);
   $pecahan = explode("\n", $modifiedString);
   $pecahan2 = explode("\n", $judul);
   $ljudul= ltrim($pecahan2[1]," ");
   $lkode= ltrim($pecahan[2]," ");
   $lnama= ltrim($pecahan[3]," ");
   $lharga= ltrim($pecahan[4]," ");
   $lstatus= ltrim($pecahan[6]," ");
   $harga = array("kode" => "$lkode", "nama" => "$lnama", "harga" => "$lharga", "status" => "$lstatus");
   $kodenya = $harga['kode'];
   $list[$kodenya] = $harga;
   $nomor++;
   $i++;
  }
  $daftar[$nomor2] = array("judul" => $ljudul, "detail" => $list);
  $nomor2++;
      }
   
  $json = json_encode($daftar);
  print($json);
  
   }

    ?>
