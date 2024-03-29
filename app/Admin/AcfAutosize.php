<?php

namespace Genesis\Admin;

class AcfAutosize
{

    public function init(): void
    {
        add_action('init', [$this, "enqueues"]);
    }

    public function enqueues(): void
    {
        add_action('admin_head', [$this, "echoCss"]);
        add_action('admin_footer', [$this, "echoJs"]);

        if (apply_filters('acf-autosize/enabledInFrontend', false)) {
            add_action('wp_head', [$this, "echoCss"]);
            add_action('wp_footer', [$this, "echoJs"]);
        }
    }

    public function echoCss(): void
    {
        echo "<style>";
        echo "body.acf-autosize-enabled .acf-field:not(.no-autosize) .mce-tinymce:not(.mce-fullscreen) .mce-top-part{position:-webkit-sticky;position:sticky;top:46px}@media (min-width: 783px){body.acf-autosize-enabled .acf-field:not(.no-autosize) .mce-tinymce:not(.mce-fullscreen) .mce-top-part{top:30px}}body.acf-autosize-enabled .block-editor .acf-field:not(.no-autosize) .mce-tinymce:not(.mce-fullscreen) .mce-top-part{top:0}.acf-field.autosize .mce-tinymce:not(.mce-fullscreen) .mce-top-part{position:-webkit-sticky;position:sticky;top:46px}@media (min-width: 783px){.acf-field.autosize .mce-tinymce:not(.mce-fullscreen) .mce-top-part{top:30px}}.block-editor .acf-field.autosize .mce-top-part{top:0}";
        echo "</style>";
    }

    public function echoJs(): void
    {
        echo "<script type=\"text/javascript\">";
        echo "ACFAutosize = {";
        echo "'wysiwyg':{'minHeight': " . apply_filters('acf-autosize/wysiwyg/min-height', 150) . "},";
        echo "'enabledByDefault':" . apply_filters('acf-autosize/enabledByDefault', true);
        echo "};";
        echo "</script>";
        echo "<script type=\"text/javascript\">";
        echo "(function(){var T={367:function(_,g){var a,p,f;(function(d,v){if(!0)p=[_,g],a=v,f=typeof a==\"function\"?a.apply(g,p):a,f!==void 0&&(_.exports=f);else var o})(this,function(d,v){\"use strict\";var o=typeof Map==\"function\"?new Map:function(){var e=[],t=[];return{has:function(r){return e.indexOf(r)>-1},get:function(r){return t[e.indexOf(r)]},set:function(r,z){e.indexOf(r)===-1&&(e.push(r),t.push(z))},delete:function(r){var z=e.indexOf(r);z>-1&&(e.splice(z,1),t.splice(z,1))}}}(),s=function(t){return new Event(t,{bubbles:!0})};try{new Event(\"test\")}catch{s=function(l){var r=document.createEvent(\"Event\");return r.initEvent(l,!0,!1),r}}function c(e){if(!e||!e.nodeName||e.nodeName!==\"TEXTAREA\"||o.has(e))return;var t=null,l=null,r=null;function z(){var n=window.getComputedStyle(e,null);n.resize===\"vertical\"?e.style.resize=\"none\":n.resize===\"both\"&&(e.style.resize=\"horizontal\"),n.boxSizing===\"content-box\"?t=-(parseFloat(n.paddingTop)+parseFloat(n.paddingBottom)):t=parseFloat(n.borderTopWidth)+parseFloat(n.borderBottomWidth),isNaN(t)&&(t=0),y()}function F(n){{var i=e.style.width;e.style.width=\"0px\",e.offsetWidth,e.style.width=i}e.style.overflowY=n}function N(n){for(var i=[];n&&n.parentNode&&n.parentNode instanceof Element;)n.parentNode.scrollTop&&i.push({node:n.parentNode,scrollTop:n.parentNode.scrollTop}),n=n.parentNode;return i}function A(){if(e.scrollHeight!==0){var n=N(e),i=document.documentElement&&document.documentElement.scrollTop;e.style.height=\"\",e.style.height=e.scrollHeight+t+\"px\",l=e.clientWidth,n.forEach(function(w){w.node.scrollTop=w.scrollTop}),i&&(document.documentElement.scrollTop=i)}}function y(){A();var n=Math.round(parseFloat(e.style.height)),i=window.getComputedStyle(e,null),w=i.boxSizing===\"content-box\"?Math.round(parseFloat(i.height)):e.offsetHeight;if(w<n?i.overflowY===\"hidden\"&&(F(\"scroll\"),A(),w=i.boxSizing===\"content-box\"?Math.round(parseFloat(window.getComputedStyle(e,null).height)):e.offsetHeight):i.overflowY!==\"hidden\"&&(F(\"hidden\"),A(),w=i.boxSizing===\"content-box\"?Math.round(parseFloat(window.getComputedStyle(e,null).height)):e.offsetHeight),r!==w){r=w;var k=s(\"autosize:resized\");try{e.dispatchEvent(k)}catch{}}}var C=function(){e.clientWidth!==l&&y()},b=function(n){window.removeEventListener(\"resize\",C,!1),e.removeEventListener(\"input\",y,!1),e.removeEventListener(\"keyup\",y,!1),e.removeEventListener(\"autosize:destroy\",b,!1),e.removeEventListener(\"autosize:update\",y,!1),Object.keys(n).forEach(function(i){e.style[i]=n[i]}),o.delete(e)}.bind(e,{height:e.style.height,resize:e.style.resize,overflowY:e.style.overflowY,overflowX:e.style.overflowX,wordWrap:e.style.wordWrap});e.addEventListener(\"autosize:destroy\",b,!1),\"onpropertychange\"in e&&\"oninput\"in e&&e.addEventListener(\"keyup\",y,!1),window.addEventListener(\"resize\",C,!1),e.addEventListener(\"input\",y,!1),e.addEventListener(\"autosize:update\",y,!1),e.style.overflowX=\"hidden\",e.style.wordWrap=\"break-word\",o.set(e,{destroy:b,update:y}),z()}function m(e){var t=o.get(e);t&&t.destroy()}function h(e){var t=o.get(e);t&&t.update()}var u=null;typeof window==\"undefined\"||typeof window.getComputedStyle!=\"function\"?(u=function(t){return t},u.destroy=function(e){return e},u.update=function(e){return e}):(u=function(t,l){return t&&Array.prototype.forEach.call(t.length?t:[t],function(r){return c(r,l)}),t},u.destroy=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],m),e},u.update=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],h),e}),v.default=u,d.exports=v.default})},451:function(_,g,a){var p=a(367);(function(f){var d;ACFAutosize.enabledByDefault?d=f(\".acf-field:not(.no-autosize) textarea\"):d=f(\".acf-field.autosize textarea\"),p(d),acf.addAction(\"ready load resize\",function(){p.update(d)}),acf.addAction(\"show_field\",function(){setTimeout(function(){p.update(d)},750)}),acf.addAction(\"append\",function(v){var o=null;ACFAutosize.enabledByDefault?o=v.find(\".acf-field:not(.no-autosize) textarea\"):o=v.find(\".acf-field.autosize textarea\"),o.length>0&&p(o)})})(window.jQuery)},248:function(_,g,a){var p=a(367);(function(f){function d(o,s){if(s===void 0&&(s=200),!o.plugins.fullscreen.isFullscreen()){var c=f(o.iframeElement).contents().find(\"html\").height()||s;c=c<s?s:c,f(o.iframeElement).css({height:c,minHeight:s})}}function v(o){var s=o.attr(\"data-name\"),c=f(\"iframe\",o).contents().find(\"body\");c.attr(\"data-wysiwyg-slug\",s)}acf.addAction(\"wysiwyg_quicktags_init\",function(o,s,c,m){p(m.\$el.find(\"textarea.wp-editor-area\"))}),acf.addAction(\"wysiwyg_tinymce_init\",function(o,s,c,m){var h=function(){d(o,ACFAutosize.wysiwyg.minHeight)};o.on(\"init\",function(){v(m.\$el)});var u=!1;ACFAutosize.enabledByDefault?u=!m.\$el.hasClass(\"no-autosize\"):u=m.\$el.hasClass(\"autosize\"),!!u&&(o.on(\"init\",h),o.on(\"change\",h),o.on(\"FullscreenStateChanged\",function(e){h()}),acf.addAction(\"load\",function(){h()}),acf.addAction(\"resize\",function(){h()}),acf.addAction(\"show_field\",function(e){setTimeout(function(){h()},750)}),setTimeout(function(){h()},1e3))})})(window.jQuery)}},x={};function E(_){var g=x[_];if(g!==void 0)return g.exports;var a=x[_]={exports:{}};return T[_].call(a.exports,a,a.exports,E),a.exports}var S={};(function(){typeof acf!=\"undefined\"&&(E(451),E(248),typeof ACFAutosize!=\"undefined\"&&ACFAutosize.enabledByDefault&&window.jQuery(\"body\").addClass(\"acf-autosize-enabled\"))})()})();";
        echo "</script>";
    }
}
