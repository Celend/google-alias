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
if(!isset($_GET[opt('GET_Q')])){
    require_once 'view.class.php';
    $index = new view();
    $index->show();
}
else{
    require_once 'google_search.class.php';
    require_once 'view.class.php';
    $q = $_GET[opt('GET_Q')];
    $p = isset($_GET[opt('GET_PAGE')]) ? $_GET[opt('GET_PAGE')] : 0;
    $d = isset($_GET[opt('GET_TIME')]) ? $_GET[opt('GET_TIME')] : FALSE;
    $n = isset($_GET[opt('GET_NUM')]) ? (int) $_GET[opt('GET_NUM')] : FALSE;
    $g = new search($q);
    if($n)
        $g->set_num($n);
    if($p)
        $g->set_page($p);
    if($d)
        $g->set_time($d);
    $g->load();
    $g->get_results();
}