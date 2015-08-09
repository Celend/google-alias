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
    private $head = '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><{title}></title>
  <meta name="description" content="Google Alias Search, 帮助无法访问谷歌的人们使用谷歌搜索, 获取更好的知识, 发现更真实的世界.">
  <meta name="keywords" content="Google Alias 谷歌 搜索 敏感词搜索">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
  <meta name="urlencrypt" content="<{encrypt}>" />
  <meta name="conencrypt" content="<{conencrypt}>" />
  <link rel="shortcut icon" type="image/x-icon" href="res/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="res/google-alias.css?v1.0.7" />
  <script src="http://libs.baidu.com/jquery/1.10.1/jquery.min.js"></script>
  <script src="res/google-alias.js?v1.1"></script>
</head>';
    private $index_body = '<body onload="index()">
<div class="i-search">
  <div class="i-logo">
    <div class="i-logo-img"></div>
    <span class="alias">Alias</span>
  </div>
  <div class="i-keywork">
    <div class="i-search-bar">
      <div class="i-box">
        <form action="./" method="get" onsubmit="return commit1()">
          <input type="text" class="i-q" autocomplete="off"/>
          <input type="hidden" value="" name="qq" id="hdq"/>
          <div class="button-bar">
            <button type="submit" class="i-search-bu" onclick="searchtype = 0">正在获取IP</button>
            <button type="submit" class="i-search-bu" onclick="searchtype = 1">敏感词搜索</button>
          </div>
        </form>
    </div>
    </div>
  </div>
</div>
  <div class="fbar" style="position: absolute">
    <div class="fb" style="margin-left: 35px">
      <a class="fa" href="https://github.com/celend/google-alias">GitHub</a>
      <a class="fa" href="https://github.com/celend/google-alias/issues">反馈</a>
      <a class="fa" href="#" onclick="index(ip_k + 1)">更换谷歌IP</a>
      <a class="fa" href="http://t55y.com" target="_blank">t55y.com</a>
      <a class="fa" href="http://googlealias.tk" target="_blank">googlealias.tk</a>
      <a class="fa contactme" style="float: right; margin-right: 35px" href="mailto:forevertjt@gmail.com">联系我 forevertjt@gmail.com</a>
    </div>
  </div>
<div style="display: none"><script src="http://v1.cnzz.com/z_stat.php?id=1253514079&web_id=1253514079" language="JavaScript"></script></div>
</body>
</html>';
    private $res_tmp = '    <li class="s-box">
     <a class="s-title" href="<{href}>"  target="_blank"><{tle}></a>
     <span class="s-title-link"><{site}></span>
     <span class="s-disc"><{disc}></span>
    </li>';
    private $s_start = '<body onload="search()">
  <div class="s-top-bar">
  <a href="./">
    <div class="s-logo">
      <img src="./res/logo11w.png" class="s-logo-img" />
      <div class="s-logo-alias">Alias</div>
    </div>
  </a>
    <div class="s-search-bar">
      <form action="./" method="get" onsubmit="return commit2()">
        <input type="text" value-t="<{key}>" class="s-q" autocomplete="off" />
        <input type="hidden" value="" name="<{GET_Q}>" id="hdq"/>
        <{fill1}>
        <button type="submit" class="s-search-bu"></button>
      </form>
    </div>
  </div>
  <div class="search-tool-bar">';
    private $reset = '<li class="no-sel tool-btn-b" id="clear">重置</li>';
    private $hidden_field = '<input class="hd-fd" type="hidden" name="<{name}>" value="<{value}>" />';
    private $s_end = '    </div>
  </div>
  <div class="fbar" style="position: relative">
    <div class="fb">
      <a class="fa" href="https://github.com/celend/google-alias">GitHub</a>
      <a class="fa" href="https://github.com/celend/google-alias/issues">反馈</a>
      <a class="fa" href="mailto:forevertjt@gmail.com">联系我 forevertjt@gmail.com</a>
    </div>
  </div>
  <div style="display: none"><script src="http://v1.cnzz.com/z_stat.php?id=1253514079&web_id=1253514079" language="JavaScript"></script></div>
</body>
</html>';
    private $notfound = '    <div>
      <p style="padding-top:.33em"> 找不到和您的查询 "<em id="tle"><{key}></em>" 相符的内容或信息。 </p>
      <p style="margin-top:1em">建议：</p>
      <ul style="margin-left:1.3em;margin-bottom:2em">
        <li>请检查输入字词有无错误。</li>
        <li>请尝试其他的查询词</li>
        <li>请改用较常见的字词。</li>
      </ul>
    </div>';
    private $toobar_s = '    <div class="tf">
      <div style="height: 39px;; overflow: hidden;">
        <div class="search-info" id="search-info">
          <{status}>
        </div>
        <div id="tool-panel">
          <ul>
            <li class="no-sel tool tool-time" id="time">时间限制<span class="dwn-tri">&#9660;</span></li>
            <li class="no-sel tool" id="num">每页结果数<span class="dwn-tri">&#9660;</span></li>
            <li class="no-sel tool" id="lang">语言<span class="dwn-tri">&#9660;</span></li>
            <{fill3}>
          </ul>
        </div>
      </div>
      <div class="tool-al" id="tool-time">
        <ul style="list-style: none;">
          <{fill1}>
        </ul>
      </div>
      <div class="tool-al" id="tool-num">
        <ul style="list-style: none;">
          <{fill2}>
        </ul>
      </div>
      <div class="tool-al" id="tool-lang">
        <ul style="list-style: none;">
          <{fill4}>
        </ul>
      </div>
    </div>
    <div class="tool-btn no-sel tool-btn-b">搜索工具</div>';
    private $toobar_e = '  </div>
  <div class="search-res <{load}>">
    <{loadmes}>
    <div style="border-bottom: 1px #e5e5e5 solid;" class="cont">
    <ul>';
    private $toobar_status = '找到约 <{num}> 条结果, 用时 <{second}> 秒.';
    private $page_G = '    </ul>
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
            </td>';
    private $page_p = '<span class="t-prev">上一页</span>';
    private $page_o1 = '            <td>
              <a class="nav-a">
                <span class="csb c-o1"></span>
                <span class="nav-n"><{num}></span>
              </a>
            </td>';
    private $page_o2 = '            <td>
              <a <{href}> class="nav-a">
                <span class="csb c-o2"></span>
                <span class="nav-n"><{num}></span>
              </a>
            </td>';
    private $page_g = '            <td>
              <a <{href}> class="nav-a s-next">
                <span class="csb c-gle"></span>
                <span class="t-next">下一页</span>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>';

    private $rel_s = '    <div style="border-top: 1px solid #e5e5e5;padding-bottom: 30px;"><h3 class="med" style="color:gray"><span id="rel"><{key}></rel>的相关搜索</span></h3>';
    private $rel_r_s = '<div class="row">';
    private $rel_tmp = "        <p class=\"_e4b\"><a href=\"<{href}>\" class=\"rel_a\"><{tle}></a></p>\n";

    private $have_hidden = FALSE;
    public $g = '';
    function __construct(search $Google_search = null){
        $tle = 'Google Alias Search';
        $this->head = str_replace('<{encrypt}>', opt('ENCRYPT') ? opt('ENCRYPT_K') : 'FALSE',
            str_replace('<{conencrypt}>', opt('CON_ENC') ? opt('CON_ENC_K') : 'FALSE', $this->head)
        );
        if(@get_class($Google_search) == 'search'){
            $this->g = $Google_search;
            $this->is_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
            $this->head = str_replace('<{title}>', opt('CON_ENC') ? encrypt($this->g->get_key().' - '.$tle, opt('CON_ENC_K')) : $this->g->get_key().' - '.$tle, $this->head);
            $this->s_start = str_replace('<{GET_Q}>', $GLOBALS['OPTIONS']['GET_Q'], $this->s_start);
            $this->type = 1;
            if(opt('CON_ENC')){
                $this->toobar_e = str_replace('<{load}>', 'loading',
                    str_replace('<{loadmes}>', '<div class="loading-mes">search results is loading...</div>',
                        $this->toobar_e)
                );
            }
            else{
                $this->toobar_e = str_replace('<{load}>', '',
                    str_replace('<{loadmes}>', '',
                        $this->toobar_e)
                );
            }
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
			//echo var_dump($this->g->results);
            if($this->g->status['errno']){
                if($this->g->status['errno'] == 404){
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
            echo str_replace('<{key}>', opt('CON_ENC') ? encrypt($this->g->get_key(), opt('CON_ENC_K')) : $this->g->get_key(),
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
        echo str_replace('<{key}>', opt('CON_ENC') ? encrypt($this->g->get_key(),opt('CON_ENC_K')) : $this->g->get_key(), $this->rel_s);
        foreach($this->g->results['related'] as $v){
            if($i % 5 == 0){
                echo $this->rel_r_s;
            }
            echo str_replace('<{href}>', $this->g->get_key_url($v),
                str_replace('<{tle}>', opt('CON_ENC') ? encrypt($v, opt('CON_ENC_K')) : $v, $this->rel_tmp)
            );
            if(($i + 1) % 5 == 0){
                echo '</div>';
            }
            $i++;
        }
        echo '</div>';
    }
} 
