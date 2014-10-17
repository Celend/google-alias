<?php
/**
 * class for display search results.
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */

class view {
    private $head = <<<EOT
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{0}</title>
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
    <div class="i-search-bra">
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
    public function show_index(){
        echo $this->head.$this->index_body;
    }
} 