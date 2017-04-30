/**
 * Created by peymanvalikhanli on 4/16/17 AD.
 */
function __require(url) {
    var scr = document.createElement('script');
    scr.setAttribute('src',url);
    document.head.appendChild(scr);
}
function __css_require(url){
    var link = document.createElement('link');
    link.setAttribute('rel','stylesheet');
    link.setAttribute('type','text/css');
    link.setAttribute('href',url);
    document.head.appendChild(link);
}