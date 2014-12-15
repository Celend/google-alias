<?php
/**
 * autocomplete class
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-11-19
 */
define("QUOTE", TRUE);
if (! isset($_GET['qq']))
    exit('0');
require_once 'config.php';
$URL = 'https://www.google.com/complete/search?client=serp&hl=zh-CN&&xhr=t&q='.urlencode($_GET['qq']);
$HEADERS = array(
    'User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',
    'referer:https://www.google.com/',
    'Host:www.google.com',
    'Accept-Encoding:deflate,sdch',
);
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, $HEADERS);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$c = curl_exec($ch);
$c = json_decode($c);
$e = array();
for($i = 0; $i < count($c[1]); $i++){
    $e[] = $c[1][$i][0];
}
echo json_encode($e);
