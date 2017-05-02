


ajax.getJSON('mnuitem','values/menu.json');

ajax.getJSON('user','values/user.json');

ajax.getJSON('lang','values/lang/fa.json');

var __lang = undefined;

setTimeout(function(){

    __lang = new lang(ajax.data.lang);
    ajax.data.lang = undefined ;

    var __menu = new menu(ajax.data.mnuitem.items);
    __menu.render();

    var __user = new users(ajax.data.user);
    __user.set_img();
    __user.set_name();



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


