<?php
/**
 * the index document
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
define("QUOTE", TRUE);
require_once 'config.php';
if(!isset($_GET['qqq'])){
    require_once 'view.class.php';
    $index = new view();
    $index->show_index();
}
else{
    require_once 'google_search.class.php';
    $c = file_get_contents('test3.html');
    preg_match('`href="/search\?q[^"]*?ei=([^"]*?)&[^"]*?"`s', $c, $e);
    var_dump($e);
    $q = $_GET['qqq'];
    $p = isset($_GET['ppp']) ? $_GET['ppp'] : 0;
    $d = isset($_GET['ddd']) ? $_GET['ddd'] : 'y';
    $n = isset($_GET['num'])? (int) $_GET['num'] : FALSE;
    $g = new Google_search($q);
    echo '<pre>';
    if($n)
        $g->set_num($n);
    if($p)
        $g->set_page($p);
    if($d)
        $g->set_time_limit($d);
    $g->load();
    echo $g->get_full_url();
    var_dump($g->get_results());
}