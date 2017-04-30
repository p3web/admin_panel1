/**
 * Created by peymanvalikhanli on 4/17/17 AD.
 */
function users(info){
    this.info= info;
}
users.prototype.set_img = function(){
    try {
        if(this.info.img != undefined || this.info.img != null ){
            //user_profile_pic
            var img = get_elem_id("user_profile_pic");
            img.setAttribute('src', this.info.img);
            //user_profile_tiny_pic
            var tiny_img = get_elem_id("user_profile_pic");
            tiny_img.setAttribute('src', this.info.img);
            return true;
        }else{return false;}
    }
    catch(e){
        console.log(e);
        return false;
    }
}

users.prototype.set_name = function(){
    try {
        if(this.info.name != undefined || this.info.name != null ){
            //username
            var name = get_elem_id("username");
            name.innerHTML = this.info.name ;
            //username_tiny
            var tiny_name = get_elem_id("username_tiny");
            tiny_name.innerHTML = this.info.name ;
            return true;
        }else{return false;}
    }
    catch(e){
        console.log(e);
        return false;
    }
}

