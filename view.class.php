<?php
/**
 * class for display search results.
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-27
 */
if(!defined('QUOTE')){
    exit('Access Denied!');
}
function opt($key){
    return $GLOBALS['OPTIONS'][$key];
}
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="res/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="res/google-alias.css" />
  <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
  <script src="res/google-alias.js"></script>
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
        <input type="text" name="<{GET_Q}>" class="i-q">
        <button type="submit" class="i-search-bu">
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
     <a class="s-title" href="<{href}>"  target="_blank"><{tle}></a>
     <span class="s-title-link"><{site}></span>
     <span class="s-disc"><{disc}></span>
    </li>
EOT;
    private $s_start = <<<EOT
<body>
  <div class="s-top-bar">
  <a href="./" style="text-">
    <div class="s-logo">
      <img src="./res/logo11w.png" class="s-logo-img" />
      <div class="s-logo-alias">Alias</div>
    </div>
  </a>
    <div class="s-search-bar">
      <form action="./" method="get" onsubmit="return true">
        <input type="text" value="<{key}>" name="<{GET_Q}>" class="s-q"/>
        <button type="submit" class="i-search-bu">
      </form>
    </div>
  </div>
  <div class="search-tool-bar">
EOT;
    private $toobar_s = <<<EOT
  <div class="tool-box">
    <div class="search-info" id="search-info">
      找到约 <{num}> 条结果, 用时 <{second}> 秒.
    </div>
    <div id="tool-panel" style="display: none">
      <ui>
        <li class="no-sel tool tool-time" id="time">时间限制<span class="dwn-tri">&#9660;</span></li>
        <div class="tool-al" id="tool-time" style="display: none;left:15px;">
          <ui style="list-style: none;">
            <{fill1}>
          </ui>
        </div>
        <li class="no-sel tool" id="num">每页结果数<span class="dwn-tri">&#9660;</span></li>
        <div class="tool-al" id="tool-num" style="display: none;left: 150px;">
          <ui style="list-style: none;">
            <{fill2}>
          </ui>
        </div>
      </ui>
    </div>
  </div>
  <div class="tool-btn-b tool-btn" id="tool-btn">
    搜索工具
  </div>
EOT;
    private $toobar_e = <<<EOT
  </div>
  <div class="search-res">
    <div style="border-bottom: 1px #e5e5e5 solid;">
EOT;
    private $s_end = <<<EOT
  </div>
</body>
</html>
EOT;
    private $page_G = <<<EOT
  </div>
    <div class="navcnt">
      <table class="nav-t">
        <tbody>
          <tr valign="top">
            <td class="s-prev">
              <a <{href}> class="nav-a s-prev">
                <span class="csb c-g"></span>
                <{page_p}>
              </a>
            </td>
EOT;
    private $page_p = '<span class="t-prev">上一页</div>';
    private $page_o1 = <<<EOT
            <td>
              <a class="nav-a">
                <span class="csb c-o1"></span>
                <span class="nav-n"><{num}></div>
              </a>
            </td>
EOT;
    private $page_o2 = <<<EOT
            <td>
              <a <{href}> class="nav-a">
                <span class="csb c-o2"></span>
                <span class="nav-n"><{num}></div>
              </a>
            </td>
EOT;
    private $page_g = <<<EOT
            <td>
              <a <{href}> class="nav-a s-next">
                <span class="csb c-gle"></span>
                <span class="t-next">下一页</div>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

EOT;
    public $g = '';
    function __construct($Google_search = null){
        $tle = 'Google Alias Search';
        $this->g = $Google_search;
        $this->is_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
        $this->head = str_replace('<{title}>', $this->g->get_key().' - '.$tle, $this->head);
        $this->s_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
        $this->type = 1;
        return $this;
    }
    /**
     * set the class
     */
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
            if($this->g == '')
                return FALSE;
            if($this->g->errno){
                echo "ERROR";
                return FALSE;
            }
            echo $this->head;
            echo str_replace('<{key}>', $this->g->key_word,$this->s_start);
            $this->show_tool_bar();
            foreach($this->g->results as $v){
                if($v['id'] != "")
                    continue;
                echo str_replace('<{disc}>', $v['info'],
                    str_replace('<{site}>', $v['site'],
                        str_replace('<{tle}>', $v['title'],
                            str_replace('<{href}>', $v['url'], $this->res_tmp)
                        )
                    )
                );
            }
            $this->show_page();
            echo $this->s_end;
        }
        else{
            echo $this->head.$this->index_body;
        }
    }
    private function show_tool_bar(){
        $t1 = array('s' => '刚刚',
            'n' => '几分钟前',
            't' => '半小时前',
            'h' => '一小时前',
            'j' => '12小时前',
            'd' => '24小时前',
            'w' => '一星期前',
            'm' => '一个月前',
            'y' => '一年前'
        );
        $t2 = array('10', '20', '30', '50', '100');
        $fill1 = '';
        $fill2 = '';
        foreach($t1 as $k => $v){
            $fill1 .= '<a class="t-l" href="'.$this->g->get_url(array(opt('GET_TIME') => $k)).'"><li class="opt">'.$v.'</li></a>';
        }
        foreach($t2 as $v){
            $fill2 .= '<a class="t-l" href="'.$this->g->get_url(array(opt('GET_TIME') => $v)).'"><li class="opt">'.$v.'</li></a>';
        }
        echo str_replace('<{second}>', $this->g->status['time'],
            str_replace('<{num}>', $this->g->status['res_num'],
                str_replace('<{fill1}>', $fill1,
                    str_replace('<{fill2}>', $fill2,$this->toobar_s)
                )
            )
        );
        echo $this->toobar_e;
    }
    private function show_page(){
        if(!$this->type)
            return FALSE;
        $cp = $this->g->get_page();
        if($cp == 1){
            echo str_replace('<{href}>', '',
                str_replace('<{page_p}>', '', $this->page_G)
            );
        }
        else{
            echo str_replace('<{page_p}>', $this->page_p,
                str_replace('<{href}>', 'href="'.
                    $this->g->get_url(array(opt('GET_PAGE') => 1)).'"', $this->page_G)
            );
        }
        if($cp <= 6){
            for($i = 1; $i <= 10; $i++){
                if($i == $cp){
                    echo str_replace('<{href}>', '',
                        str_replace('<{num}>', $i, $this->page_o1)
                    );
                }
                else{
                    echo str_replace('<{href}>',
                        'href="'.$this->g->get_url(array(opt('GET_PAGE') => $i)).'"',
                        str_replace('<{num}>', $i, $this->page_o2)
                    );
                }
            }
        }
        else{
            for($i = $cp - 5; $i < $cp + 5; $i++){
                if($i == $cp){
                    echo str_replace('<{href}>', '',
                        str_replace('<{num}>', $i, $this->page_o1)
                    );
                }
                else{
                    echo str_replace('<{href}>',
                        'href="'.$this->g->get_url(array(opt('GET_PAGE') => $i)).'"',
                        str_replace('<{num}>', $i, $this->page_o2)
                    );
                }
            }
        }
        echo str_replace('<{href}>', 'href="'.$this->g->get_url(array(opt('GET_PAGE') => $cp + 1)).'"', $this->page_g);
    }
} 