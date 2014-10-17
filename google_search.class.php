<?php
/**
 * parsing the google search response data
 * @package parsing
 * @author celend
 */
if(!defined('QUOTE'))
    exit('Access Denied!');
class Google_search {

    public $paras = array();      //parameters
    public $headers = "";
    public $content = "";          //html content
    public $start = 0;             //results offset
    public $num = 10;

    public $key_word = '';
    public $url = 'https://www.google.com/search?';
    public $ress = array();         //original results
    public $res_num = '';            //results total
    public $time = '';               //search time
    public $results = array();      //assorted results
    function __construct($key){
        $this->key_word = $key;
        $this->paras['hl'] = 'zh-CN';
        $this->paras['num'] = $this->num;
        if($GLOBALS['OPTIONS']['SAFE_SEARCH'])
            $this->paras['safe'] = 'strict';
    }
    //load the html data
    public function load(){
        global $headers;
        $this->paras['q'] = $this->key_word;
        $p = $this->arr2url($this->paras);
        $ch = curl_init($this->url.$p);
        curl_setopt_array($ch, $headers);
        if(HAVE_GZIP && $GLOBALS['OPTIONS']['ENABLE_GZIP'])
            $this->content = zlib_decode(curl_exec($ch));
        else
            $this->content =curl_exec($ch);
        $this->remove_css_and_js();
        preg_match('`<div id="resultStats"[^>]*>[^\d]*([\d,]*)[^<]*<nobr>[^\d]*([\d\.]*)[^<]*</nobr></div>`m', $this->content, $re);
        $this->res_num = $re[1];
        $this->time = $re[2];
    }

    /**
     * url paras convert into array key-value pairs
     * @param string
     * @return array
     */
    public static function url2arr($str){
        if(!is_string($str))
            return FALSE;
        parse_str($str, $f);
        return $f;
    }

    /**
     * array convert into url
     * @param $paras_arr
     * @return bool|string
     */
    public static function arr2url($paras_arr){
        if(!is_array($paras_arr))
            return FALSE;
        $s = '';
        foreach($paras_arr as $k => $v){
            $s .= urlencode($k).'='.urlencode($v).'&';
        }
        return $s;
    }
    private function add_parse($key, $value){
        $this->paras[$key] = $value;
    }
    private function get_current_page(){
        return floor($this->start / 10);
    }
    private function remove_css_and_js(){
        $this->content = str_replace("\n", '', $this->content);
        $this->content = preg_replace('`<script[^>]*>.*?</script>`', '', $this->content);
        $this->content = preg_replace('`<style[^>]*>.*?</style>`', '', $this->content);
    }
    function get_results(){
        $s = $this->content;
        preg_match('`<p[^>]+?class="_e4b"[^>]*><a[\s\S]+?href="/search\?[^"]*?ei=([^&]+)[^"]*">`s', $s, $th);
        $regex = '`<li[^>]+class="[^"]+"[^>]*>.*?<div[^>]class="rc"[^>]*><h3 class="r"><a[^>]+?href="([^"]+)"[^>]*>(.+?)</a>.*?'.
        '</h3>.+?<span[^>]+class="st">(<span[^>]+class="[^"]*?"[^>]*>.*?</span>.*?|.*?)</span>.*?</li>`s';
        preg_match_all($regex, $s, $this->ress, PREG_SET_ORDER);
        foreach($this->ress as $k => $v){
            $this->results[] = array(
                'url'   => $v[1],
                'title' => $v[2],
                'info'  => $v[3]
            );
        }
        return $this->results;
    }
    public function get_url(){
        return $this->url;
    }
    public function get_content(){
        return $this->content;
    }

    /**
     * set the search results before some time.
     * @param char
     * @return bool
     */
    public function set_time_limit($str){
        if(!is_string($str))
            return FALSE;
        $str = strtolower($str);
        if(!isset($this->paras['tbs']))
            $this->paras['tbs'] = '';
        else
            $this->paras['tbs'] .= ',';
        switch($str){
            case 'h':
                $this->paras['tbs'] .= 'qdr:h';break;
            case 'd':
                $this->paras['tbs'] .= 'qdr:d';break;
            case 'w':
                $this->paras['tbs'] .= 'qdr:w';break;
            case 'm':
                $this->paras['tbs'] .= 'qdr:m';break;
            case 'y':
                $this->paras['tbs'] .= 'qdr:y';break;
            default:
                return False;
        }
        return TRUE;
    }

    /**
     * set page number
     * @param int
     * @return bool
     */
    public function set_page($num){
        $this->start = $num * $this->num;
        $this->paras['start'] = $this->start;
        return TRUE;
    }
    public function get_full_url(){
        return $this->url.$this->arr2url($this->paras);
    }
    public function set_num($num){
        $num = (int) $num;
        $this->num = $num;
        $this->paras['num'] = $num;
    }
    public function set_keywork($key){
        $key = urlencode($key);
        $this->key_word = $key;
    }
}