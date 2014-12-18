/**
 * javascript
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
this.searchtype = 0;
'use strict';(function(d){function h(a,b,e){var c="rgb"+(d.support.rgba?"a":"")+"("+parseInt(a[0]+e*(b[0]-a[0]),10)+","+parseInt(a[1]+e*(b[1]-a[1]),10)+","+parseInt(a[2]+e*(b[2]-a[2]),10);d.support.rgba&&(c+=","+(a&&b?parseFloat(a[3]+e*(b[3]-a[3])):1));return c+")"}function f(a){var b;return(b=/#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/.exec(a))?[parseInt(b[1],16),parseInt(b[2],16),parseInt(b[3],16),1]:(b=/#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/.exec(a))?[17*parseInt(b[1],16),17*parseInt(b[2],16),17*parseInt(b[3],16),1]:(b=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(a))?[parseInt(b[1]),parseInt(b[2]),parseInt(b[3]),1]:(b=/rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9\.]*)\s*\)/.exec(a))?[parseInt(b[1],10),parseInt(b[2],10),parseInt(b[3],10),parseFloat(b[4])]:l[a]}d.extend(!0,d,{support:{rgba:function(){var a=d("script:first"),b=a.css("color"),e=!1;if(/^rgba/.test(b))e=!0;else try{e=b!=a.css("color","rgba(0, 0, 0, 0.5)").css("color"),
a.css("color",b)}catch(c){}return e}()}});var k="color backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor outlineColor".split(" ");d.each(k,function(a,b){d.Tween.propHooks[b]={get:function(a){return d(a.elem).css(b)},set:function(a){var c=a.elem.style,g=f(d(a.elem).css(b)),m=f(a.end);a.run=function(a){c[b]=h(g,m,a)}}}});d.Tween.propHooks.borderColor={set:function(a){var b=a.elem.style,e=[],c=k.slice(2,6);d.each(c,function(b,c){e[c]=f(d(a.elem).css(c))});var g=f(a.end);
    a.run=function(a){d.each(c,function(d,c){b[c]=h(e[c],g,a)})}}};var l={aqua:[0,255,255,1],azure:[240,255,255,1],beige:[245,245,220,1],black:[0,0,0,1],blue:[0,0,255,1],brown:[165,42,42,1],cyan:[0,255,255,1],darkblue:[0,0,139,1],darkcyan:[0,139,139,1],darkgrey:[169,169,169,1],darkgreen:[0,100,0,1],darkkhaki:[189,183,107,1],darkmagenta:[139,0,139,1],darkolivegreen:[85,107,47,1],darkorange:[255,140,0,1],darkorchid:[153,50,204,1],darkred:[139,0,0,1],darksalmon:[233,150,122,1],darkviolet:[148,0,211,1],fuchsia:[255,0,255,1],gold:[255,215,0,1],green:[0,128,0,1],indigo:[75,0,130,1],khaki:[240,230,140,1],lightblue:[173,216,230,1],lightcyan:[224,255,255,1],lightgreen:[144,238,144,1],lightgrey:[211,211,211,1],lightpink:[255,182,193,1],lightyellow:[255,255,224,1],lime:[0,255,0,1],magenta:[255,0,255,1],maroon:[128,0,0,1],navy:[0,0,128,1],olive:[128,128,0,1],orange:[255,165,0,1],pink:[255,192,203,1],purple:[128,0,128,1],violet:[128,0,128,1],red:[255,0,0,1],silver:[192,192,192,1],white:[255,255,255,1],yellow:[255,255,0,1],transparent:[255,255,255,0]}})(jQuery);
!function(a){"use strict";var d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,b=a.Base64,c="2.1.4";"undefined"!=typeof module&&module.exports&&(d=require("buffer").Buffer),e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",f=function(a){var c,d,b={};for(c=0,d=a.length;d>c;c++)b[a.charAt(c)]=c;return b}(e),g=String.fromCharCode,h=function(a){var b;return a.length<2?(b=a.charCodeAt(0),128>b?a:2048>b?g(192|b>>>6)+g(128|63&b):g(224|15&b>>>12)+g(128|63&b>>>6)+g(128|63&b)):(b=65536+1024*(a.charCodeAt(0)-55296)+(a.charCodeAt(1)-56320),g(240|7&b>>>18)+g(128|63&b>>>12)+g(128|63&b>>>6)+g(128|63&b))},i=/[\uD800-\uDBFF][\uDC00-\uDFFFF]|[^\x00-\x7F]/g,j=function(a){return a.replace(i,h)},k=function(a){var b=[0,2,1][a.length%3],c=a.charCodeAt(0)<<16|(a.length>1?a.charCodeAt(1):0)<<8|(a.length>2?a.charCodeAt(2):0),d=[e.charAt(c>>>18),e.charAt(63&c>>>12),b>=2?"=":e.charAt(63&c>>>6),b>=1?"=":e.charAt(63&c)];return d.join("")},l=a.btoa?function(b){return a.btoa(b)}:function(a){return a.replace(/[\s\S]{1,3}/g,k)},m=d?function(a){return new d(a).toString("base64")}:function(a){return l(j(a))},n=function(a,b){return b?m(a).replace(/[+\/]/g,function(a){return"+"==a?"-":"_"}).replace(/=/g,""):m(a)},o=function(a){return n(a,!0)},p=new RegExp(["[À-ß][-¿]","[à-ï][-¿]{2}","[ð-÷][-¿]{3}"].join("|"),"g"),q=function(a){switch(a.length){case 4:var b=(7&a.charCodeAt(0))<<18|(63&a.charCodeAt(1))<<12|(63&a.charCodeAt(2))<<6|63&a.charCodeAt(3),c=b-65536;return g((c>>>10)+55296)+g((1023&c)+56320);case 3:return g((15&a.charCodeAt(0))<<12|(63&a.charCodeAt(1))<<6|63&a.charCodeAt(2));default:return g((31&a.charCodeAt(0))<<6|63&a.charCodeAt(1))}},r=function(a){return a.replace(p,q)},s=function(a){var b=a.length,c=b%4,d=(b>0?f[a.charAt(0)]<<18:0)|(b>1?f[a.charAt(1)]<<12:0)|(b>2?f[a.charAt(2)]<<6:0)|(b>3?f[a.charAt(3)]:0),e=[g(d>>>16),g(255&d>>>8),g(255&d)];return e.length-=[0,0,2,1][c],e.join("")},t=a.atob?function(b){return a.atob(b)}:function(a){return a.replace(/[\s\S]{1,4}/g,s)},u=d?function(a){return new d(a,"base64").toString()}:function(a){return r(t(a))},v=function(a){return u(a.replace(/[-_]/g,function(a){return"-"==a?"+":"/"}).replace(/[^A-Za-z0-9\+\/]/g,""))},w=function(){var c=a.Base64;return a.Base64=b,c},a.Base64={VERSION:c,atob:t,btoa:l,fromBase64:v,toBase64:n,utob:j,encode:n,encodeURI:o,btou:r,decode:v,noConflict:w},"function"==typeof Object.defineProperty&&(x=function(a){return{value:a,enumerable:!1,writable:!0,configurable:!0}},a.Base64.extendString=function(){Object.defineProperty(String.prototype,"fromBase64",x(function(){return v(this)})),Object.defineProperty(String.prototype,"toBase64",x(function(a){return n(this,a)})),Object.defineProperty(String.prototype,"toBase64URI",x(function(){return n(this,!0)}))})}(this);
$( document ).ready(function(){
    $('.tool-btn').on('click', function(e){
        $('.tool-al').hide();
        if(!$('#tool-panel').is(':visible')){
            $(this).removeClass('tool-btn').addClass('tool-btn-press');
            $('#tool-panel').show();
            $('#search-info').animate({
                'marginTop': '-40px'
            }, 150);
        }
        else{
            $(this).removeClass('tool-btn-press').addClass('tool-btn');
            $('#search-info').animate({
                'marginTop': 0
            }, 150, function(){
                $('#tool-panel').hide();
            });
        }
    });
    $('.tool').on('click', function(e){
        var type = $(this).attr('id');
        $('.tool-al').not('#tool-'+type).hide();
        var ele = $('#tool-'+type);
        if(ele.is(':visible'))
            ele.hide();
        else
            ele.show();
        $('body').one('click', function(e){
            ele.hide();
        });
        return false;
    });
    $('#clear').on('click', function(){
        $('.hd-fd').remove();
        $(this).hide(0, function(){
            $(this).remove();
            $('.s-q').css('color', '#FFF');
            $('.s-q').animate({
                'backgroundColor': '#F00'
            }, 50, function(){
                $('.s-q').animate({
                    'color'          : '#000',
                    'backgroundColor': '#FFF'
                }, 1000);
            })
        });
    })
});
function encrypt(str, key){
    var s = '';
    var t = '';
    for(var i = 0; i < str.length; ++i){
        if(encodeURI(str[i]) == str[i]){
            s += str[i];
        }
        else{
            var c = encodeURI(str[i]);
            c = c.split('%');
            var f = [];
            for(var j = 1; j < c.length; ++j){
                t = parseInt(parseInt(c[j], 16) - key).toString(16).toLocaleUpperCase();
                if(t.length == 1)
                    t = '0' + t;
                f.push(t);
            }
            s += '%' + f.join('%');
        }
    }
    return '%FF' + s;
}
//extend
$.fn.decrypt = function(key){
    try{
        this.html(decrypt(this.html(), key));
    }
    catch(e){
        console.log(e);
    }
    return this;
}
var table = {'40':'@', '23':'#', '24':'$', '26':'&', '2F':'/', '3B':';', '3A':':', '3F':'?', '2C':',', '3D':'='};
function decrypt(str, key){
    if(str.substr(0, 3) == '%FF'){
        str = str.substr(3);
    }
    var t = '';
    var s = '';
    for(var i = 0; i < str.length; ++i){
        if(str[i] == '+'){
            s += ' ';
        }
        else if(str[i] != '%'){
            s += str[i];
        }
        else{
            t = parseInt(parseInt(str.substr(i + 1, 2), 16) + key).toString(16).toLocaleUpperCase();
            if(t.length == 1){
                s = '0' + t;
            }
            if(table[t] != undefined){
                s += table[t];
            }
            else{
                s += '%' + t;
            }
            i += 2;
        }
    }
    return decodeURI(s);
};

var avaip = '';
var ips = [];
var ip_k = 0;
function index(modify){
    if(typeof modify == 'string' && modify.length > 6){
        avaip = modify;
        return true;
    }
    if(modify){
        if(ips.length <= 1){
            $('.fa:eq(2)').html('暂无可用IP');
            return false;
        }
        ips.splice(0, modify);
        ip_k = 0;
    }
    else{
        $('.i-q').focus();
    }
    var inUse = false;
    function testip(state, callback){
        if(state){
            avaip = ips[ip_k];
            console.info('now google ip is:' + avaip);
            if(callback)
            callback();
            return true;
        }
        else{
            ip_k++;
            ping(callback)
        }
    }
    function ping(callback){
        if(!inUse){
            var img = new Image();
            inUse = true;
            img.onload = function(){
                if(inUse){
                    inUse = false;
                    testip(true, callback);
                }
            }
            img.onerror = function(){
                if(inUse){
                    inUse = false;
                    testip(true, callback);
                }
            }
            img.src = 'http://' + ips[ip_k] + '/images/srpr/logo11w.png';
            setTimeout(function(){
                if(inUse){
                    inUse = false;
                    testip(false, callback);
                }
            }, 500);
        }
    }
    if(modify){
        ping(function(){
            $('.i-q').stop().animate({
                'backgroundColor': '#F00'
            }, 50, function(){
                $(this).animate({
                    'backgroundColor': '#FFF'
                }, 1000);
            });
        });
    }
    else{
        $.ajax({
            'type': 'get',
            'url': './google_avaiable_ip.txt',
            'success': function(d){
                ips = d.split('|');
                ips.sort(function(){ return 0.5 - Math.random() });
                ping(function(){
                    $('.i-search-bu')[0].innerHTML = 'Google搜索';
                });
            },
            'error': function(){
                alert('从服务器获取可用IP失败, 请联系管理员');
            }
        });
    }
}
function commit1(){
    if($('.i-q')[0].value == '')
        return false;
    if(searchtype === 0){
        if(avaip == ''){
            return false;
        }
        window.open('http://' + avaip + '/search?newwindow=1&q=' + encodeURI($('.i-q')[0].value), '_blank');
        return false;
    }
    else if(searchtype === 1){
        $('#hdq').attr('value', encrypt($('.i-q')[0].value, Number($('meta[name=urlencrypt]').attr('content'))));
        $('#i-f').submit();
    }
    return true;
}
function commit2(){
    if($('.s-q')[0].value == '')
        return false;
    $('#hdq').attr('value', encrypt($('.s-q')[0].value, Number($('meta[name=urlencrypt]').attr('content'))));
    return true;
}
function search(s){
    var k = Number($('meta[name=conencrypt]').attr('content'));
    $('.s-q').attr('value', decrypt($('.s-q').attr('value-t'), k));
    if($('meta[name=conencrypt]').attr('content') != 'FALSE'){
        $('title').decrypt(k);
        if($('#rel').length > 0)
            $('#rel').decrypt(k);
        var s = $('.s-title');
        for(var i = 0; i < s.length; ++i){
            $(s[i]).attr('href', decrypt($(s[i]).decrypt(k).attr('href'), k));

        }
        s = $('.s-disc');
        for(i = 0; i < s.length; ++i){
            $(s[i]).decrypt(k);
        }
        s = $('.rel_a');
        for(i = 0; i < s.length; ++i){
            $(s[i]).decrypt(k);
        }
        s = $('.s-title-link');
        for(i = 0; i < s.length; ++i){
            $(s[i]).decrypt(k);
        }
        $('.loading-mes').fadeOut(100, function(){
            $('.loading-mes').remove();
            $('.cont').fadeIn(300, function(){
                $('.search-res').removeClass('loading');
            });
        });
    }
    $('.s-q').focus();
    var s = $('.s-q')[0];
    if(s.setSelectionRange){
        s.setSelectionRange(s.value.length, s.value.length);
    }
    else{
        var r = s.createTextRange();
        r.collapse(true);
        r.moveStart('character', s.value.length);
        r.select();
    }
};
window.onkeydown = function(e){
    if($('.s-q').is(':focus') || $('.i-q').is(':focus'))
        return true;
    if(e.altKey && (e.key == 'j' || 'j'.charCodeAt(0) - 32 == e.keyCode) && !e.shiftKey){
        if($('.i-q').length > 0)
            $('.i-q').focus();
        else{
            $('.s-q').focus();
        }
    }
    else if(e.altKey && (e.key == 'i' || 'i'.charCodeAt(0) - 32 == e.keyCode) && !e.shiftKey){
        if($('.i-q').length > 0)
            $('.i-q').focus()[0].value = '';
        else{
            $('.s-q').focus()[0].value = '';
        }
    }
    return true;
}
