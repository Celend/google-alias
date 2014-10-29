google-alias
============
这是一个用 PHP 写的谷歌搜索, 主要使用 php 的 curl 和 preg 模块.
Google Alias 意为谷歌的替代品.
##部署##
部署非常简单, 你甚至不用做什么, 只要把你的代码上传到 VPS 或者 web host.
大家都知道 PHP 的免费主机非常多, 部署也非常便捷. 大范围的部署也不成问题, 即使被墙也能迅速的更换主机.
##配置##
config.php 里面有许多个性化的设置, 比如自定义 GET 的键名, 默认的每页结果数, 或者你可以自定义http的header, 是否开启安全搜索等等等
##功能##
1. 限制时间
2. 可定义每页结果数
3. 相关搜索
3. 设置地区和语言(未实现, 可以通过修改headers)
4. 返回新闻, 视频, 图片的搜索结果(未实现)
5. 兼容特殊搜索, 比如特定的文件(未实现)
5. url关键字加密(未实现)
6. 待续

##BUGs##
1. 没有搜索结果时会报错(fixed)
2. 你找找看


##hosts##
附送hosts, 可以上facebook, google, twitter, dropbox, wikiPedia等, hosts内有说明更新日期.
不保证可以正常使用, 建议备份原来的hosts

##可用服务##
1. http://googlealias.tk 主站, 更新的内容会在这里测试
2. http://tjt.hol.es  //同上, 不同域名而已, .tk解析不了的话就用这个
3. http://tjt.pagebit.net
4. http://tj.pagebit.net
5. http://tjt.bugs3.com
