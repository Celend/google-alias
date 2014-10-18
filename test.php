<?php
/**
 * the index document
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
define("QUOTE", TRUE);
error_reporting(E_ALL);
require_once 'config.php';
if(!isset($_GET['qqq'])){
    require_once 'view.class.php';
    $index = new view();
    $index->show();
}
else{
    require_once 'google_search.class.php';
    require_once 'view.class.php';
    $q = $_GET['qqq'];
    $p = isset($_GET['ppp']) ? $_GET['ppp'] : 0;
    $d = isset($_GET['ddd']) ? $_GET['ddd'] : 'y';
    $n = isset($_GET['num'])? (int) $_GET['num'] : FALSE;
    $g = new Google_search($q);
    if($n)
        $g->set_num($n);
    if($p)
        $g->set_page($p);
    if($d)
        $g->set_time_limit($d);
    $g->load();
    $g->get_results();
    $v = new view($g, $g->key_word.' - Google Alias Search', 'search');
    $v->show();
}