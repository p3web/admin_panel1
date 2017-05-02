<?php


//include "API.php";

require_once '../model/data_access/access.php';
require_once '../model/data_access/lang.php';

session_start();
if (!isset($_REQUEST["act"])) {
    exit;
}
switch ($_REQUEST["act"]) {

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
            extit;
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
    default:

        echo "bilah";

}

function check_validation($field)
{

    $result['is_valid'] = true;

    for ($i = 0; count($field) > $i; $i++) {
        if (isset($_REQUEST[$field[$i]])) {
            $result[$field[$i]] = true;
        } else {
            $result[$field[$i]] = false;
            $result['is_valid'] = false;
        }
    }

    return $result;

}

function send_msg($msg, $title,$type = "error", $btn = "")
{
    send_result(array('msg' => $msg, 'title' => $title, 'type'=>$type , 'btn'=>$btn ,  'act' => 'message' ));
}

function send_result($res)
{
    echo json_encode($res);
}