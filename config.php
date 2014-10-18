<?php
/**
 * configuration file
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
if(!defined('QUOTE'))
    exit('Access Denied!');

if(function_exists('zlib_decode'))
    define("HAVE_GZIP", TRUE);
else
    define("HAVE_GZIP", FALSE);

$GLOBALS['OPTIONS'] = array(
    'SAFE_SEARCH' => FALSE,
    'ENABLE_GZIP' => TRUE,
    'TIMEOUT'     => 3,
    'NUM'         => 10,
    'GET_Q'       => 'qqq',
    'GET_PAGE'    => 'ppp',
    'GET_NUM'     => 'num',
    'GET_TIME'    => 'ddd',
    'DOMAIN'      => 'http://googlealias.tk/'
);
$headers = array(
    CURLOPT_HTTPHEADER => array(
        'user-agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36',
        'referer:https://www.google.com/'
    ),
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_BINARYTRANSFER => TRUE,
    CURLOPT_HEADER         => TRUE,
    CURLOPT_CONNECTTIMEOUT => $GLOBALS['OPTIONS']['TIMEOUT']        //set connect timeout
);
if(HAVE_GZIP && $GLOBALS['OPTIONS']['ENABLE_GZIP'])
    $headers[] = 'accept-encoding:gzip,deflate';

