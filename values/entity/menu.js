/**
 * Created by peymanvalikhanli on 4/17/17 AD.
 */
function menu(menu_items){
    this.items = menu_items ;
}
menu.prototype.render = function(){
    var menu_body = get_elem_id("sidebar-menu");

    if(this.items.length>0){
        for(var index = 0 ; index < this.items.length ; index++){

            var menu_section =set_elem("div");
            menu_section.setAttribute('class','menu_section');
            var h3 = set_elem("h3");
            h3.innerHTML = __lang.translate(this.items[index].name) ;
            menu_section.appendChild(h3);
            if(this.items[index].items != undefined && this.items[index].items.length>0){
                var ul = set_elem('ul');
                ul.setAttribute('class','nav side-menu');
                for(var subindex = 0 ; subindex < this.items[index].items.length ; subindex++) {
                    var child_menu_id =this.items[index].items[subindex].name + Math.floor((Math.random() * 1000) + 1);
                    var li = set_elem("li");
                    var a = set_elem("a");
                    var i_tag = set_elem("i");
                    i_tag.setAttribute('class', this.items[index].items[subindex].icon);
                    a.setAttribute('onclick', 'show_sub_menu("'+child_menu_id+'")');
                    a.appendChild(i_tag);
                    a.innerHTML += __lang.translate(this.items[index].items[subindex].name);
                    li.appendChild(a);

                    if (this.items[index].items[subindex].items != undefined && this.items[index].items[subindex].items.length > 0) {
                        var span_tag = set_elem("span");
                        span_tag.setAttribute('class', 'fa fa-chevron-down');
                        //span_tag.setAttribute('onclick', 'show_sub_menu("'+child_menu_id+'")');
                        a.appendChild(span_tag);
                        var subul = set_elem("ul");
                        subul.setAttribute('class', 'nav child_menu');
                        subul.setAttribute('id', child_menu_id);
                        for (var _subindex = 0; _subindex < this.items[index].items[subindex].items.length; _subindex++) {
                            var subli = set_elem("li");
                            var suba = set_elem('a');
                            if(this.items[index].items[subindex].items[_subindex].url != undefined) {
                                suba.setAttribute('href', this.items[index].items[subindex].items[_subindex].url);
                            }else{
                                suba.setAttribute('link', this.items[index].items[subindex].items[_subindex].link);
                                suba.setAttribute('href', this.items[index].items[subindex].items[_subindex].link);
                                suba.setAttribute('onclick', 'menu_item_onclick(this)');
                            }
                            suba.innerHTML =__lang.translate(this.items[index].items[subindex].items[_subindex].name);
                            subli.appendChild(suba);
                            subul.appendChild(subli);
                        }
                        li.appendChild(subul);
                    }
                    ul.appendChild(li);
                }
                menu_section.appendChild(ul);
            }
        }
        menu_body.appendChild(menu_section);
    }

}

function menu_item_onclick(elem) {
    var link = elem.getAttribute("href");
    document.location.hash = link;
}

function show_sub_menu(id){
    var ul = get_elem_id(id);
    var style = getComputedStyle(ul);
    if(style.display == "none"){
        ul.style.display = "block";
    }else{
        ul.style.display = "none";
    }
}