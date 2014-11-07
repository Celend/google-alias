<?php
/**
 * the index document
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-27
 */
define("QUOTE", TRUE);
error_reporting(E_ALL);
session_start();
require_once 'config.php';
if(!isset($_SESSION['ENC_K'])){
    $_SESSION['ENC_K'] = rand(-10, 10);
}
$GLOBALS['OPTIONS']['ENCRYPT_K'] = $_SESSION['ENC_K'];
if(!isset($_GET[opt('GET_Q')])){
    require_once 'view.class.php';
    $index = new view();
    $index->show();
}
else{
    require_once 'google_search.class.php';
    require_once 'view.class.php';
    $q = $_GET[opt('GET_Q')];
    $h = isset($_GET[opt('GET_LANG')]) ? $_GET[opt('GET_LANG')] : FALSE;
    $p = isset($_GET[opt('GET_PAGE')]) ? $_GET[opt('GET_PAGE')] : 0;
    $d = isset($_GET[opt('GET_TIME')]) ? $_GET[opt('GET_TIME')] : FALSE;
    $n = isset($_GET[opt('GET_NUM')]) ? (int) $_GET[opt('GET_NUM')] : FALSE;
    if(substr($q, 0, 3) == '%FF' && opt('ENCRYPT'))
        $q = decrypt($q, opt('ENCRYPT_K'));
    $g = new search($q);
    if($n)
        $g->set_num($n);
    if($p)
        $g->set_page($p);
    if($d)
        $g->set_time($d);
    if($h)
        $g->set_lang($h);
    $g->load();
    $g->get_results();
    $s = new view($g);
    $s->show();
}