

var __lang = undefined;

$.getJSON('values/lang/fa.json', function(data){
    __lang = new lang(data);
} );

$.getJSON('values/user.json' , function(data){
    var __user = new users(data);
    __user.set_img();
    __user.set_name();
} );

setTimeout(function(){

    $.getJSON('values/menu.json' , function(data){
        var __menu = new menu(data.items);
        __menu.render();
    } );

}, 1000);





var loadPage = function(url){
    if(url != "") {
        $.get(url + ".html", function (data, status) {
            if (status == 'success') {
                var html = ejs.render(data, {});
                var mainPageContent = get_elem_id('page_body');
                mainPageContent.innerHTML = html;
            } else {
                console.log("erorr 404 : cannot open page html file. PSCO log :D");
            }
        });
    }
}

$(window).on('hashchange', function() {
    var hash = document.location.hash.substring(1);

    if(hash != "" || hash != undefined )
    {
        loadPage(hash);
        console.log(hash);
    }
});
$(window).trigger("hashchange");

function windows_full_screen() {

    var el = document.documentElement,
        rfs = el.requestFullscreen
            || el.webkitRequestFullScreen
            || el.mozRequestFullScreen
            || el.msRequestFullscreen
        ;

    rfs.call(el);
}