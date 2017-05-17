<?php


//include "API.php";

require_once '../model/data_access/access.php';
require_once '../model/data_access/lang.php';

session_start();
if (!isset($_REQUEST["act"])) {
    exit;
}
switch ($_REQUEST["act"]) {
//    case 'get_all_users':
//        send_result(access::get_all_users());
//        break;
    case 'test':
        send_result(access::get_all_articles_join_page());
        break;
    case 'logout':
        try {

            $_SESSION = null;
            session_destroy();
        } catch (Exception $e) {
        }
        send_result(array('act' => 'logout'));
        break;
    case 'register':
        $f = array('email', 'pass', 'avatar', 'username');
        $valid_data = check_validation($f);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_user($_REQUEST['email'], $_REQUEST['pass'], $_REQUEST['avatar'], $_REQUEST['username']);
        if (is_numeric($res)) {
            $_SESSION['user'] = access::get_user_by_email_pass($_REQUEST['email'], $_REQUEST['pass']);
            send_result(array('Result' => 'profile.html', 'act' => 'location'));
            exit;
        } else {
            send_msg(lang::$last_registered_data, lang::$error);
            exit;
        }
        break;
    case 'login':
        //session_start();
        $f = array('email', 'pass');
        $valid_data = check_validation($f);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $_SESSION['user'] = access::get_user_by_email_pass($_REQUEST['email'], $_REQUEST['pass']);
        if (isset($_SESSION['user']) && isset($_SESSION['user'][0]['email'])) {//ß== $_REQUEST['email'])){
            access::set_user_login($_SESSION['user'][0]['id']);
            send_result(array('Result' => 'index.html', 'act' => 'location'));
            exit;
        } else {
            send_msg(lang::$is_not_login, lang::$error);
            exit;
        }

        break;
    case 'edit_profile':
        $f = array('username', 'name', 'email', 'cart_no', 'shaba_no', 'sex', 'address');
        $valid_data = check_validation($f);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::edit_user($_SESSION['user'][0]['id'], $_REQUEST['username'], $_REQUEST['name'], $_REQUEST['sex'], $_REQUEST['address'], $_REQUEST['email'], $_REQUEST['cart_no'], $_REQUEST['shaba_no']);
        $_SESSION['user'] = access::get_user_by_email_pass($_SESSION['user'][0]['email'], $_SESSION['user'][0]['password']);
        if ($res == 1) {
            send_result(array('Result' => 'Home.html', 'act' => 'location'));
            exit;
        } else {
            send_msg(lang::$is_not_set_profile, lang::$error);
            exit;
        }


        /* TODO: register on game
       $Player = $_REQUEST["Player"];
       $RealName = $_REQUEST["RealName"];
       $Gender = $_REQUEST["Gender"];
       $Location = $_REQUEST["Location"];
       $Password1 = $_REQUEST["PW"];
       $Email = $_REQUEST["Email"];
       $Avatar = $_REQUEST["Avatar"];

       $params = array("Command"  => "AccountsAdd",
           "Player"   => $Player,
           "RealName" => $RealName,
           "PW"       => $Password1,
           "Location" => $Location,
           "Email"    => $Email,
           "Avatar"   => $Avatar,
           "Gender"   => $Gender,
           "Chat"     => "Yes",
           "Note"     => "Account created via API");
       $api = Poker_API($params);
       print_r($params);
       echo json_encode($api);
       */

        break;
    case 'get_user':
        //session_start();
        if (!isset($_SESSION['user'][0]['email'])) {
            send_result(array('Result' => 'login.html', 'act' => 'location'));
            exit;
        }
        $_SESSION['user'][0]['act'] = 'get_user';
        send_result($_SESSION['user'][0]);
        break;
    case 'cash_out':
        //session_start();
        $f = array('Payment', 'cartnumber', 'cartname', 'cartbank');
        $valid_data = check_validation($f);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_peyment($_SESSION['user'][0]['id'], $_SESSION['user'][0]['username'], $_REQUEST['Payment'], $_REQUEST['cartnumber'], $_REQUEST['cartname'], $_REQUEST['cartbank']);
        send_msg(lang::$register_data, lang::$message);
        break;
    case 'get_user_by_username' :
        $res = access::get_user_by_username_or_email($_REQUEST['user']);
        $res['act']='get_user_by_username';
        send_result($res);
        break;
    case 'get_all_menus':
            send_result(access::get_all_menu());
        break;
    case 'get_all_roles':
        send_result(access::get_all_role());
        break;
    case 'get_all_maps':
        send_result(access::get_all_map());
        break;
    case 'get_all_pages':
        send_result(access::get_all_page());
        break;
    case 'get_all_articles':
        send_result(access::get_all_articles());
        break;
    case 'get_all_userroles':
        send_result(access::get_all_user_role());
        break;
    case 'get_all_slider':
        send_result(access::get_all_slider());
        break;
    case 'get_all_imagebox':
        send_result(access::get_all_imagebox());
        break;
    case 'get_menu_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_menu_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_role_by_id':
        $valid_data = check_validation(array("id"));
        print_r($valid_data);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_role_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_map_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_map_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_page_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_page_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_article_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_articles_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_userrole_by_userid':
        $valid_data = check_validation(array("userid"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_user_role_by_user_id($_REQUEST['userid']);
        send_result($res);
        break;
    case 'get_slider_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_slider_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'get_imagebox_by_id':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_imagebox_by_id($_REQUEST['id']);
        send_result($res);
        break;
    case 'set_page':
        $arr = array("title");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data,lang::$error);
            exit;
        }
        $res = access::set_page($_REQUEST['title'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_menu':
        $arr = array("name", "parentid", "pageid", "url", "image");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_menu($_REQUEST['name'], $_REQUEST['parentid'], $_REQUEST['pageid'], $_REQUEST['url'], $_REQUEST['image'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_article':
        $arr = array("pageid", "priority", "content", "metadata");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_articles($_REQUEST['pageid'], $_REQUEST['priority'], $_REQUEST['content'], $_REQUEST['metadata'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_role':
        $arr = array("role");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_role($_REQUEST['role'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_userrole':
        $arr = array("userid", "roleid");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_user_role($_REQUEST['userid'], $_REQUEST['roleid'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_map':
        $arr = array("lat", "long", "icon");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::set_map($_REQUEST['lat'], $_REQUEST['long'], $_REQUEST['icon']);
        print_r($res);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_slider':
        $arr = array("title", "image", "url", "pageid", "content");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data,lang::$error);
            exit;
        }
        $res = access::set_slider($_REQUEST['title'], $_REQUEST['image'], $_REQUEST['url'], $_REQUEST['pageid'], $_REQUEST['content'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'set_imagebox':
        $arr = array("image", "content", "url", "pageid");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data,lang::$error);
            exit;
        }
        $res = access::set_imagebox($_REQUEST['image'], $_REQUEST['content'], $_REQUEST['url'], $_REQUEST['pageid'], $_SESSION['user'][0]['id']);
        if(is_numeric($res)){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$last_registered_data, lang::$error);
        }
        break;
    case 'delete_page':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_page($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$failed, lang::$failed);
        }
        break;
    case 'delete_menu':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_menu($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'delete_article':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_articles($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'delete_map':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_map($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'delete_role':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_role($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'delete_userrole':
        $valid_data = check_validation(array("userid"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_user_role($_REQUEST['userid'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'delete_slider':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_slider($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$failed, lang::$failed);
        }
        break;
    case 'delete_imagebox':
        $valid_data = check_validation(array("id"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if (access::delete_imagebox($_REQUEST['id'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$failed, lang::$failed);
        }
        break;
    case 'update_page':
        $arr = array("id", "title");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_page($_REQUEST['id'], $_REQUEST['title'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_menu':
        $arr = array("id", "name", "parentid", "pageid", "url", "image");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_menu($_REQUEST['id'], $_REQUEST['name'], $_REQUEST['parentid'], $_REQUEST['pageid'], $_REQUEST['url'], $_REQUEST['image'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_article':
        $arr = array("id", "pageid", "priority", "content", "metadata");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_articles($_REQUEST['id'], $_REQUEST['pageid'], $_REQUEST['priority'], $_REQUEST['content'], $_REQUEST['metadata'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_role':
        $arr = array("id", "role");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_role($_REQUEST['id'], $_REQUEST['role'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_userrole':
        $arr = array("userid", "roleid");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_user_role($_REQUEST['userid'], $_REQUEST['roleid'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_map':
        $arr = array("id", "lat", "long", "icon");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_map($_REQUEST['id'], $_REQUEST['lat'], $_REQUEST['long'], $_REQUEST['icon'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_slider':
        $arr = array("id", "title", "image", "url", "pageid", "content");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_slider($_REQUEST['id'], $_REQUEST['title'], $_REQUEST['image'], $_REQUEST['url'],$_REQUEST['pageid'],$_REQUEST['content'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'update_imagebox':
        $arr = array("id", "image", "content", "url", "pageid");
        $valid_data = check_validation($arr);
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        if(access::update_imagebox($_REQUEST['id'], $_REQUEST['image'], $_REQUEST['content'], $_REQUEST['url'],$_REQUEST['pageid'])){
            send_msg(lang::$success,"success", lang::$message);
        }else{
            send_msg(lang::$invalid_data, lang::$failed);
        }
        break;
    case 'get_articles_page':
        $valid_data = check_validation(array("pageid"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_articles_page($_REQUEST['pageid']);
        send_result($res);
        break;
    case 'get_parent_menus':
        $valid_data = check_validation(array("parentid"));
        if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
            send_msg(lang::$invalid_data, lang::$error);
            exit;
        }
        $res = access::get_parent_menus($_REQUEST['parentid']);
        send_result($res);
        break;

    default:
        send_result(false);
}

function check_validation($field){
    $result['is_valid'] = true;
    for ($i = 0; count($field) > $i; $i++) {
        if (isset($_REQUEST[$field[$i]]) && !empty($_REQUEST[$field[$i]])) {
            $result[$field[$i]] = true;
        } else {
            $result[$field[$i]] = false;
            $result['is_valid'] = false;
        }
    }
    return $result;
}

function send_msg($msg, $title,$type = "error", $btn = ""){
    send_result(array('msg' => $msg, 'title' => $title, 'type'=>$type , 'btn'=>$btn ,  'act' => 'message' ));
}

function send_result($res){
    echo json_encode($res);
}