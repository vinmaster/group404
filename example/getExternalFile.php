<?php

/**
 * Fetch the specified page source, even if fopen_url_wrapper is disabled
 * For that purpose, we use the curl wrapper. It should work everywhere
 * 
 * @param String $url The url to fetch
 * @return String The page source code
 */
function getPage($url="http://www.example.com/"){
 $ch = curl_init();
 curl_setopt($ch,CURLOPT_URL, $url);
 curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
 curl_setopt($ch,CURLOPT_REFERER,'http://www.google.ch/');
 curl_setopt($ch,CURLOPT_TIMEOUT,10);
 $html=curl_exec($ch);
 if($html==false){
  $m=curl_error(($ch));
  error_log($m);
 }
 curl_close($ch);
 return $html;
}

$html=getPage("http://www.reddit.com/.json");
$html=htmlentities($html);
echo $html;

?>