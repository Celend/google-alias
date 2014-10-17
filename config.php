<?php
if(!defined('QUOTE'))
    exit('Access Denied!');
if(function_exists('zlib_decode'))
    define("HAVE_GZIP", TRUE);
else
    define("HAVE_GZIP", FALSE);

$GLOBALS['OPTIONS'] = array(
    'SAFE_SEARCH' => TRUE,
    'ENABLE_GZIP' => TRUE
);
$headers = array(
    CURLOPT_HTTPHEADER => array(
        'accept-language:zh-CN,zh;q=0.8',
        'user-agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36',
        'referer:https://www.google.com/',
        'accept:text/html;q=0.9,*/*;q=0.8'
    ),
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_BINARYTRANSFER => TRUE
);
if(HAVE_GZIP && $GLOBALS['OPTIONS']['ENABLE_GZIP'])
    $headers[] = 'accept-encoding:gzip,deflate';

