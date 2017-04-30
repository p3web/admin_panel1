/**
 * Created by peymanvalikhanli on 4/17/17 AD.
 */
var ajax = {
    url : "http://elec-store.com/api.php"
    ,data : {}
};

ajax.get_data=function(data){

    switch (data.act){

        case 'login':
            switch (data.Result){
                case 'valid':
                    //TODO: set modal message
                    break;
                case 'login':
                    var url = "Home.html"
                    window.location.href = url;
                    window.location = url;
                    break;
            }
            //console.log(data);
            break;
        case 'location':
            var url = data.Result;
            window.location.href = url;
            window.location = url;
            console.log(data.Result);
            break;
        case 'get_user':
            user= data ;
            break;
        case 'message':
            dial_box.show(data.title , data.msg ,'close_dialog()' , 'close_dialog()');
            break;
        case 'Error':
            console.log(data);
            break;
        default :
        //alert(data);
    }

}

ajax.sender_data =  function(param) {

    var d = new Date();
    var baseUrl = this.url + '?killcatch='+d.getMilliseconds() + '0' + d.getSeconds();

    var data_request = {};

    if (param != null) {

        var keys_param = Object.keys(param);

        for (i = 0; i < keys_param.length; i++) {
            data_request[keys_param[i]] = param[keys_param[i]];
        }
    }

    $.ajax({
        headers: { 'Access-Control-Allow-Origin': '*' },
        crossDomain: true,
        url: baseUrl,
        //type: 'POST',
        type: 'GET',
        data: data_request,
        statusCode: {
            404: function () {
                alert("404");
                var a = document.getElementById("txt_email");
                a.value = "404";
            },
            403: function () {
                alert("403");
                var a = document.getElementById("txt_email");
                a.value = "403";
            }
        },
        success: function (data) {
            //var a = document.getElementById("txt_email");
            //a.value = data;
            var dd = JSON.parse(data);
            ajax.get_data(dd);

        },
        error: function() {  var a = document.getElementById("txt_email");
            a.value = "error"; }
    });

};

ajax.getJSON = function(index , url) {
    var JSONdata = '';
    $.getJSON(url, function (data) {
        ajax.data[index]= data;
    });
}