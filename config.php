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
    'TIMEOUT'     => 3,         //连接超时, second
    'ENCRYPT'     => TRUE,     //是否开启URL参数加密
    'ENCRYPT_K'   => 8,         //URL加密的密钥, 建议在正负10之内
    'CON_ENC'     => TRUE,     //是否开启网页内容加密
    'CON_ENC_K'   => 6,         //网页内容加密的秘钥
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
        'User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',
        'referer:https://www.google.com/',
        'Host:www.google.com',

    ),
//以下内容如无必要请不要修改
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_BINARYTRANSFER => TRUE,
    CURLOPT_HEADER         => TRUE,
    CURLOPT_CONNECTTIMEOUT => $GLOBALS['OPTIONS']['TIMEOUT']        //set connect timeout
);
if(HAVE_GZIP && $GLOBALS['OPTIONS']['ENABLE_GZIP'])
    $headers[] = 'accept-encoding:gzip';



//functions
/**
 * get config
 * @param string $key
 * @return string
 */
function opt($key){
    return $GLOBALS['OPTIONS'][$key];
}

/**
 * simple decryption
 * @param string $str
 * @param int $key
 * @return string
 */
function decrypt($str, $key){
    if(substr($str, 0, 3) == '%FF')
        $str = substr($str, 3);
    $s = '';
    $len = strlen($str);
    for($i = 0; $i < $len; ++$i){
        if($str[$i] != '%'){
            $s .= $str[$i];
        }
        else{
            $t = dechex(hexdec(substr($str, $i + 1, 2)) + $key);
            if(strlen($t) == 1)
                $t = '0'.$t;
            $s .= '%'.$t;
            $i += 2;
        }
    }
    return urldecode($s);
}
function encrypt($str, $key){
    $s = '';
    for($i = 0; $i < strlen($str); $i++){
        if($str[$i] == ' '){
            $s .= '+';
        }
        elseif(urlencode($str[$i]) == $str[$i]){
            $s .= $str[$i];
        }
        else{
            $c = urlencode($str[$i]);
            $c = explode('%', $c);
            $f = array();
            for($j = 1; $j < count($c); $j++){
                $t = strtoupper(dechex(hexdec($c[$j]) - $key));
                if(strlen($t) == 1)
                    $t = '0'.$t;
                $f[] = $t;
            }
            $s .= '%'.implode('%', $f);
        }
    }
    return '%FF'.$s;
}