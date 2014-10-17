<?php
/**
 * Created by celend
 * Date: 14-10-15
 * Time: 下午8:51
 */
define("QUOTE", TRUE);
require_once 'google_search.class.php';
require_once 'config.php';
$c = file_get_contents('test3.html');
preg_match('`<p[^>]+?class="_e4b"[^>]*><a[\s\S]+?href="/search\?[^"]*?ei=([^&]+)[^"]*">`s', $c, $e);
var_dump($e);
/*$q = $_GET['qqq'];
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
var_dump($g->get_results());*/