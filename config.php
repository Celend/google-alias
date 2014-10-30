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
    'SAFE_SEARCH' => FALSE,     //安全搜索
    'LANG'        => 'zh-CN',   //默认的搜索语言
    'ENABLE_GZIP' => TRUE,      //gzip 压缩, 启用之后可节省近3分之一的流量, 前提是有gzip的模块, 否则开启也是无效的.
    'TIMEOUT'     => 3,         //连接超时
    'NUM'         => 10,        //默认的每页结果数
    'GET_LANG'    => 'hl',      //设置语言的get键名
    'GET_Q'       => 'qq',      //查询内容的get键名
    'GET_PAGE'    => 'pp',      //页数的get键名
    'GET_NUM'     => 'num',     //每页结果数的get键名
    'GET_TIME'    => 'dd',      //时间限制的get键名
    'DOMAIN'      => 'http://googlealias.tk/'   //网站的域名
);
$headers = array(
    CURLOPT_HTTPHEADER => array(    //http headers, 可以根据需求来修改
        'user-agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36',
        'referer:https://www.google.com/'
    ),
//以下内容如无必要请不要修改
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_BINARYTRANSFER => TRUE,
    CURLOPT_HEADER         => TRUE,
    CURLOPT_CONNECTTIMEOUT => $GLOBALS['OPTIONS']['TIMEOUT']        //set connect timeout
);
if(HAVE_GZIP && $GLOBALS['OPTIONS']['ENABLE_GZIP'])
    $headers[] = 'accept-encoding:gzip';
function opt($key){
    return $GLOBALS['OPTIONS'][$key];
}