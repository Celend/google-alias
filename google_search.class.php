<?php
/**
 * class for parsing google search results
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend0
 * @date 14-10-27
 */
function opt($key){
    return $GLOBALS['OPTIONS'][$key];
}
class search{
    private $cookie = array();
    private $content = '';
    private $paras = array();

    public $paras_m = array();
    public $status = array();
    public $results = array();

    const url = 'https://www.google.com/search?';

    /**
     * construct function.
     * @param string $keywork
     */
    function __construct($keywork){
        $this->paras['q'] = $keywork;
        $this->paras_m[opt('GET_Q')] = $keywork;
        $this->paras['num'] = opt('NUM');
        if(opt('SAFE_SEARCH'))
            $this->paras['safe'] = 'strict';
        $this->paras['start'] = 0;
        $this->paras['hl'] = opt('LANG');
    }

    /**
     * prepare parameters to load html data.
     * @return $this
     */
    public function load(){
        global $headers;
        $paras = $this->arr2url($this->paras);
        $ch = curl_init(search::url.$paras);
        curl_setopt_array($ch, $headers);
        $this->content = curl_exec($ch);
        $this->status['errno'] = curl_errno($ch);
        if($this->status['errno'])
            return FALSE;
        if(HAVE_GZIP && opt('GZIP_ENABLE'))
            $this->content = zlib_decode($this->content);
        $this->remove_css_and_js();
        return $this;
    }

    /**
     * remove the style and javascript tag from content.
     * @return $this
     */
    private function remove_css_and_js(){
        $this->content = str_replace("\n", '', $this->content);
        $this->content = preg_replace('`<script[^>]*>.*?</script>`', '', $this->content);
        $this->content = preg_replace('`<style[^>]*>.*?</style>`', '', $this->content);
        return $this;
    }
    /**
     * arr convert into url.
     * @param $arr
     * @return string
     */
    public static function arr2url($arr){
        if(!is_array($arr))
            return FALSE;
        $s = '';
        foreach($arr as $k => $v){
            $s .= urlencode($k).'='.urlencode($v).'&';
        }
        $s = substr($s, 0, count($s) - 2);
        return $s;
    }

    /**
     * url convert into url.
     * @param $str
     * @return array
     */
    public static function url2arr($str){
        if(!is_string($str))
            return FALSE;
        parse_str($str, $f);
        return $f;
    }

    /**
     * set the results per page.
     * @param int $num
     * @return $this
     */
    public function set_num($num){
        $this->paras['num'] = $num;
        $this->paras_m[opt('GET_NUM')] = $num;
        return $this;
    }

    /**
     * set the page number.
     * @param int $p
     * @return $this
     */
    public function set_page($p){
        $this->paras['start'] = ($p - 1) * $this->paras['num'];
        $this->paras_m[opt('GET_PAGE')] = $p;
        return $this;
    }

    /**
     * set the search language use standard language code. see https://sites.google.com/site/tomihasa/google-language-codes
     * @param string $lang
     * @return $this
     */
    public function set_lang($lang){
        $this->paras_m[opt('GET_LANG')] = $lang;
        $this->paras['hl'] = $lang;
        return $this;
    }

    /**
     * set time before, e.g. h12 = before 12 hours, m30 = before 30 minutes.
     * @param $str
     * @return $this
     */
    public function set_time($str){
        if(!is_string($str))
            return FALSE;
        $str = strtolower($str);
        if(!isset($this->paras['tbs'])){
            $this->paras['tbs'] = '';

        }
        else
            $this->paras['tbs'] .= ',';
        switch($str){
            //just now
            case 's':
                $this->paras['tbs'] .= 'qdr:s';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //few minutes ago
            case 'n':
                $this->paras['tbs'] .= 'qdr:n';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //half of hour ago
            case 't':
                $this->paras['tbs'] .= 'qdr:n30';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //half of day ago
            case 'j':
                $this->paras['tbs'] .= 'qdr:h12';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //a hour ago
            case 'h':
                $this->paras['tbs'] .= 'qdr:h';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //a day ago
            case 'd':
                $this->paras['tbs'] .= 'qdr:d';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //a weekend ago
            case 'w':
                $this->paras['tbs'] .= 'qdr:w';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //a month ago
            case 'm':
                $this->paras['tbs'] .= 'qdr:m';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            //a year ago
            case 'y':
                $this->paras['tbs'] .= 'qdr:y';
                $this->paras2[$GLOBALS['OPTIONS']['GET_TIME']] = $str;
                break;
            default:
                return False;
        }
        return $this;
    }
    /**
     * parsing the html data to array.
     * @return $this
     */
    function get_results(){
        if($this->status['errno'])
            return FALSE;
        $c = 0;
        $s = array();
        while(TRUE){
            $s1 = stripos($this->content, '<li class="g"', $c);
            $s2 = stripos($this->content, '<li class="g"', $s1 + 15);
            if(!$s2){
                $e = substr($this->content, $s1);
                $s3 = strripos($e, '</li>') + 5;
                $s[] = substr($this->content, $s1, $s3);
                break;
            }
            $e  = substr($this->content, $s1, $s2);
            $s3 = strripos($e, '</li>') + 5;
            $s[] = substr($this->content, $s1, $s3);
            $c = $s2;
        }
        for($i = 0; $i < count($s); $i++){
            $id_reg = '@<li[^>]+class="g"[^>]?(?:id="([^"]*)")?[^>]*>@s';
            preg_match($id_reg, $s[$i], $r);
            $id = isset($r[1]) ? $r[1] : '';
            $href_reg = '@<h3[^>]+class="r"><a href="([^"]*)"[^>]*>(.*?)</a>@s';
            preg_match($href_reg, $s[$i], $r);
            $href = isset($r[1]) ? $r[1] : '';
            $tle  = isset($r[2]) ? $r[2] : '';
            $disc_reg = '@<span[^>]+class="st"[^>]*>((?:<span[^>]+class="f">.*?</span>)?.*?)</span>@s';
            preg_match($disc_reg, $s[$i], $r);
            $disc = isset($r[1]) ? $r[1] : '';
            $site_reg = '@<cite[^>]+class="_Rm[^"]*"[^>]*>(.*?)</cite>@s';
            preg_match($site_reg, $s[$i], $r);
            $site = isset($r[1]) ? $r[1] : '';
            $this->results[] = array('id' => $id, 'url' => $href, 'title' => $tle, 'info' => $disc, 'site' => $site);
        }
        return $this;
    }

    /**
     * return current page number;
     * @return int
     */
    public function get_page(){
        return floor($this->paras['start'] / $this->paras['num']) + 1;
    }

    /**
     * use by view class, this is url builder, not original url;
     * @param array $paras
     * @param string key
     * @param string value
     * @return string url
     */
    public function get_url($paras = null, $key = null, $val = null){
        $tmp = $this->paras_m;
        if(is_array($paras)){
            foreach($paras as $k => $v){
                $tmp[$k] = $v;
            }
        }
        elseif($key !== null && $val !== null){
            $tmp[$key] = $val;
        }
        return './?'.$this->arr2url($tmp);
    }
    public function get_key(){
        return $this->paras['q'];
    }
    //debug
    public function debug_url(){
        return search::url.$this->arr2url($this->paras);
    }
};