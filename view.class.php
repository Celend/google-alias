<?php
/**
 * class for display search results.
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */

class view {

    private $type = 0;
    private $head = <<<EOT
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><{title}></title>
  <meta name="description" content="Google Alias">
  <meta name="keywords" content="Google Alias">
  <link rel="shortcut icon" type="image/x-icon" href="res/favicon.ico" />
  <script src="res/google-alias.js"></script>
  <link rel="stylesheet" type="text/css" href="res/google-alias.css" />
</head>
EOT;
    private $index_body = <<<EOT
<body>
<div class="i-search">
  <div class="i-logo">
    <div class="i-logo-img"></div>
    <span class="alias">Alias</span>
  </div>
  <div class="i-keywork">
    <div class="i-search-bar">
      <form action="./" method="get" onsubmit="return document.getElementsByClassName('i-q')[0].value==''?false:true">
        <input type="text" placeholder="23" name="qqq" class="i-q">
        <button type="submit" class="i-search-bu">
          <img src="res/search.png" />
        </button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
EOT;
    private $res_tmp = <<<EOT
    <li class="s-box">
    <a class="s-title" href="<{href}>"><{tle}></a>
    <span class="s-title-link"><{site}></span>
    <span class="s-disc"><{disc}></span>
    </li>
EOT;
    private $s_start = <<<EOT
<body>
  <div class="s-top-bar">
    <div class="s-logo">
      <div class="s-logo-img"></div>
      <div class="s-logo-alias">Alias</div>
    </div>
    <div class="s-search-bar">
      <form action="./" method="get" onsubmit="return true">
        <input type="text" value="<{key}>" name="qqq" class="s-q"/>
        <button type="submit" class="i-search-bu">
      </form>
    </div>
  </div>
  <div class="search-tool-bar">
  
  </div>
  <div class="search-res">
EOT;
    private $s_end = <<<EOT
  </div>
</body>
</html>
EOT;
    public $data = '';

    /**
    * construct function
    * @param $Google_search accept a Google_search class, this class must be called get_results() method.
    * @param $tle set the html title
    * @param $type set the type to be display, index or search
    * @return bool
    */
    function __construct($Google_search = ''){
        $tle = 'Google Alias Search';
        if(@get_class($Google_search) == 'Google_search'){
            $this->data = $Google_search;
            $this->head = str_replace('<{title}>', $this->data->key_word.' - '.$tle, $this->head);
            $this->type = 1;
        }
        else{
            $this->type = 0;
            $this->head = str_replace('<{title}>', $tle, $this->head);
        }
        return $this;
    }
    /**
    * set the
    */
    public function set_data($Google_search){
        if(get_class($Google_search) != 'Google_search')
            return FALSE;
        $this->type = 1;
        return $this;
    }
    public function set_type($str){
        switch($str){
            case 'index': $this->type = 0;break;
            case 'search': $this->type = 1;break;
            default: return FALSE;
        }
        return $this;
    }
    function show(){
        if($this->type){
            if($this->data == '')
                return FALSE;
            if($this->data->errno){
                echo "ERROR";
                return FALSE;
            }
            echo $this->head;
            echo str_replace('<{key}>', $this->data->key_word,$this->s_start);
            foreach($this->data->results as $v){
                echo str_replace('<{disc}>', $v['info'],
                  str_replace('<{site}>', $v['site'],
                    str_replace('<{tle}>', $v['title'],
                    str_replace('<{href}>', $v['url'], $this->res_tmp)
                    )
                  )
                );
            }
            echo $this->s_end;
        }
        else{
            echo $this->head.$this->index_body;
        }
    }
} 