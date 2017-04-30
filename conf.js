
__require("template/vendors/jquery/dist/jquery.min.js"); //jQuery
__require("plugin/ejs/ejs.js");
__require("plugin/global/main.js");
__require("plugin/network/ajax.js");
__require("plugin/lang/lang.js");
__require("values/entity/menu.js");
__require("values/entity/user.js");


__css_require("template/vendors/bootstrap/dist/css/bootstrap.min.css"); //Bootstrap

__css_require("template/vendors/font-awesome/css/font-awesome.min.css"); //Font Awesome

__css_require("template/vendors/nprogress/nprogress.css"); //NProgress

__css_require("template/vendors/google-code-prettify/bin/prettify.min.css"); //bootstrap-wysiwyg

__css_require("template/build/css/custom.min.css"); //Custom styling plus plugins


function load_menu(){
    __require("plugin/masterPage/main.js");
}
function loader_script(){

    __require("template/vendors/bootstrap/dist/js/bootstrap.min.js"); //Bootstrap

    __require("template/vendors/fastclick/lib/fastclick.js"); //FastClick
 //   __require("template/vendors/nprogress/nprogress.js"); //NProgress

    __require("template/build/js/custom.min.js"); //Custom Theme Scripts






}
