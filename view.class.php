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
      <form action="./" method="get" onsubmit="return document.getElementsByClassName('s-q')[0].value == '' ? false : true">
        <input type="text" value="<{key}>" name="<{GET_Q}>" class="s-q"/>
        <{fill1}>
        <button type="submit" class="i-search-bu"></button>
      </form>
    </div>
  </div>
  <div class="search-tool-bar">
EOT;
    private $reset = '<li class="no-sel tool-btn-b" id="clear">重置</li>';
    private $hidden_field = '<input class="hd-fd" type="hidden" name="<{name}>" value="<{value}>" />';
    private $s_end = <<<EOT
    </div>
  </div>
</body>
</html>
EOT;
    private $notfound = <<<EOT
    <div>
      <p style="padding-top:.33em"> 找不到和您的查询 "<em><{key}></em>" 相符的内容或信息。 </p>
      <p style="margin-top:1em">建议：</p>
      <ul style="margin-left:1.3em;margin-bottom:2em">
        <li>请检查输入字词有无错误。</li>
        <li>请尝试其他的查询词</li>
        <li>请改用较常见的字词。</li>
      </ul>
    </div>
EOT;
    private $toobar_s = <<<EOT
    <div class="tf">
      <div style="height: 39px;; overflow: hidden;">
        <div class="search-info" id="search-info">
          <{status}>
        </div>
        <div id="tool-panel">
          <ui>
            <li class="no-sel tool tool-time" id="time">时间限制<span class="dwn-tri">&#9660;</span></li>
            <li class="no-sel tool" id="num">每页结果数<span class="dwn-tri">&#9660;</span></li>
            <li class="no-sel tool" id="lang">语言<span class="dwn-tri">&#9660;</span></li>
            <{fill3}>
          </ui>
        </div>
      </div>
      <div class="tool-al" id="tool-time" style="display: none;left:165px;">
        <ui style="list-style: none;">
          <{fill1}>
        </ui>
      </div>
      <div class="tool-al" id="tool-num" style="display: none;left: 272px;">
        <ui style="list-style: none;">
          <{fill2}>
        </ui>
      </div>
      <div class="tool-al" id="tool-lang" style="display: none;left: 375px;">
        <ui style="list-style: none;">
          <{fill4}>
        </ui>
      </div>
    </div>
    <div class="tool-btn no-sel tool-btn-b">搜索工具</div>
EOT;
    private $toobar_e = <<<EOT
  </div>
  <div class="search-res">
    <div style="border-bottom: 1px #e5e5e5 solid;">
EOT;
    private $toobar_status = '找到约 <{num}> 条结果, 用时 <{second}> 秒.';
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
    private $page_p = '<span class="t-prev">上一页</span>';
    private $page_o1 = <<<EOT
            <td>
              <a class="nav-a">
                <span class="csb c-o1"></span>
                <span class="nav-n"><{num}></span>
              </a>
            </td>
EOT;
    private $page_o2 = <<<EOT
            <td>
              <a <{href}> class="nav-a">
                <span class="csb c-o2"></span>
                <span class="nav-n"><{num}></span>
              </a>
            </td>
EOT;
    private $page_g = <<<EOT
            <td>
              <a <{href}> class="nav-a s-next">
                <span class="csb c-gle"></span>
                <span class="t-next">下一页</span>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

EOT;

    private $rel_s = <<<EOT
    <div style="border-top: 1px solid #e5e5e5;padding-bottom: 30px;"><h3 class="med" style="color:gray"><{key}>的相关搜索</h3>
EOT;
    private $rel_r_s = '<div class="row">';
    private $rel_tmp = "        <p class=\"_e4b\"><a href=\"<{href}>\"><{tle}></a></p>\n";

    private $have_hidden = FALSE;
    public $g = '';
    function __construct(search $Google_search = null){
        $tle = 'Google Alias Search';
        if(@get_class($Google_search) == 'search'){
            $this->g = $Google_search;
            $this->is_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
            $this->head = str_replace('<{title}>', $this->g->get_key().' - '.$tle, $this->head);
            $this->s_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
            $this->type = 1;
        }
        else{
            $this->type = 0;
            $this->index_body = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->index_body);
            $this->head = str_replace('<{title}>', $tle, $this->head);
        }
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
            if($this->g == ''){
                return FALSE;
            }
            $s = '';
            $t = $this->g->get_commit_paras();
            if(count($t) > 0){
                $this->have_hidden = TRUE;
                foreach($t as $k => $v){
                    $s .= str_replace('<{name}>', $k,
                        str_replace('<{value}>', $v, $this->hidden_field)
                    );
                }
            }
            if($this->g->status['errno']){
                if($this->g->status['errno'] == 404){
                    echo $this->head;
                    echo str_replace('<{key}>', $this->g->get_key(),
                        str_replace('<{fill1}>', $s ,$this->s_start)
                    );
                    $this->show_tool_bar();
                    echo str_replace('<{key}>', $this->g->get_key(), $this->notfound);
                    echo $this->s_end;
                }
                return FALSE;
            }
            echo $this->head;
            echo str_replace('<{key}>', $this->g->get_key(),
                str_replace('<{fill1}>', $s ,$this->s_start)
            );
            $this->show_tool_bar();
            foreach($this->g->results as $k => $v){
                if(((int) $k) == FALSE && $k !== 0)
                    continue;
                if($v['id'] != ""){
                    continue;
                }
                echo str_replace('<{disc}>', $v['info'],
                    str_replace('<{site}>', $v['site'],
                        str_replace('<{tle}>', $v['title'],
                            str_replace('<{href}>', $v['url'], $this->res_tmp)
                        )
                    )
                );
            }
            if($this->g->results['related'])
                $this->show_related();
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
        $t3 = array('zh-CN' => '中文-简体', 'en' => '英语',  'zh-TW' => '中文-繁体');
        $fill1 = '';
        $fill2 = '';
        $fill4 = '';
        foreach($t1 as $k => $v){
            $fill1 .= '<a class="t-l" href="'.$this->g->get_url(array(opt('GET_TIME') => $k)).'"><li class="opt">'.$v.'</li></a>';
        }
        foreach($t2 as $v){
            $fill2 .= '<a class="t-l" href="'.$this->g->get_url(array(opt('GET_NUM') => $v)).'"><li class="opt">'.$v.'</li></a>';
        }
        foreach($t3 as $k => $v){
            $fill4 .= '<a class="t-l" href="'.$this->g->get_url(array(opt('GET_LANG') => $k)).'"><li class="opt">'.$v.'</li></a>';
        }
        if($this->have_hidden)
            $s = $this->reset;
        else
            $s = '';
        if($this->g->status['errno'] == 404){
            echo str_replace('<{status}>' , '&nbsp;',
                    str_replace('<{fill1}>', $fill1,
                        str_replace('<{fill2}>', $fill2,
                            str_replace('<{fill3}>', $s,
                                str_replace('<{fill4}>', $fill4,$this->toobar_s)
                            )
                        )
                    )
                );
            }
        else{
            echo str_replace('<{second}>', $this->g->status['time'],
                str_replace('<{num}>', $this->g->status['res_num'],
                    str_replace('<{fill1}>', $fill1,
                        str_replace('<{fill2}>', $fill2,
                            str_replace('<{status}>', $this->toobar_status,
                                str_replace('<{fill3}>', $s,
                                    str_replace('<{fill4}>', $fill4,$this->toobar_s)
                                )
                            )
                        )
                    )
                )
            );
        }
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
                    $this->g->get_url(array(opt('GET_PAGE') => ($cp - 1))).'"', $this->page_G)
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
    private function show_related(){
        $i = 0;
        echo str_replace('<{key}>', $this->g->get_key(), $this->rel_s);
        foreach($this->g->results['related'] as $v){
            if($i % 5 == 0){
                echo $this->rel_r_s;
            }
            echo str_replace('<{href}>', $this->g->get_key_url($v),
                str_replace('<{tle}>', $v, $this->rel_tmp)
            );
            if(($i + 1) % 5 == 0){
                echo '</div>';
            }
            $i++;
        }
        echo '</div>';
    }
} 