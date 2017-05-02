<?php

//try {
require_once '../model/database/data.php';


//catch (Exception $e){
//require_once 'model/database/data.php';
//}
class access
{

	public static function get_user_by_email_pass($email , $pass)
	{
		//
		$data = data::selects('`users`', "`email` = '$email' AND  `password` ='$pass'" );
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function set_user($emial, $password , $avatar , $username)
	{
		return data::insertinto("`users`", "`ID`,`password`,`email`,`avatar`,`username`, `creationDate`", "NULL, '" . $password . "', '" . $emial . "', '" . $avatar . "', '" . $username . "', DATE_SUB( CURRENT_TIME(), INTERVAL 30 MINUTE)");
	}

	public static function edit_user($id,$username,$name,$sex,$address,$email,$cart,$sheba)
	{
		return data::update("`users`", "`username` = '$username'  , `name` = '$name' ,  `sex`= '$sex' ,  `address` = '$address' ,  `email` = '$email' ,  `cart` = '$cart' , `sheba` = '$sheba'","`id`='$id'");
	}

	public static function set_user_login($id)
	{
		return data::update("`users`", "`last_login` = DATE_SUB( CURRENT_TIME(), INTERVAL 30 MINUTE)","`id`='$id'");
	}

	public static function set_peyment($userid, $username, $Payment, $cartnumber, $cartname, $cartbank)
	{
		data::insertinto("`payment_list`", "`userid`, `username`, `Payment`, `cartnumber`, `cartname`, `cartbank`", "$userid , '$username' , '$Payment' , '$cartnumber' , '$cartname' , '$cartbank'" );
	}

	public static function get_user_by_username_or_email($user)
	{
		//
		$data = data::selects('`users`', "`email` like '%$user%' OR  `username` like '%$user%'" );

		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

}

/*

	public static function get_pages()
	{

		$data = data::selects('`pages`', "");
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function get_pages_id($id)
	{

		$data = data::selects('`pages`', "`ID`=" . $id);
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function get_pages_parentID($id)
	{

		$data = data::selects('`pages`', "`parentID`=" . $id);
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function set_page($title, $parent)
	{
		data::insertinto("`pages`", "`ID`, `title`, `parentID`, `creationDate`", "NULL, '" . $title . "', '" . $parent . "', CURRENT_TIMESTAMP");
	}

	public static function get_page_content($id)
	{

		$data = data::selects('`page_content`', "`pageID`=" . $id);
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function del_page($id)
	{
		data::delete("`pages`", "`ID`=$id");
	}

	public static function set_page_content($id, $content)
	{
		data::delete("`page_content`", "`pageID`=$id");
		data::insertinto("`page_content`", "`ID`, `pageID`, `content`, `creationDate`", "NULL, '" . $id . "', '" . $content . "', CURRENT_TIMESTAMP");

	}

	public static function set_product($name, $dec, $img)
	{
		data::insertinto("`product`", "`ID`, `name`, `dec`, `img`, `creationDate`", "NULL, '$name','$dec', '$img', CURRENT_TIMESTAMP");
	}

	public static function del_product($id)
	{
		data::delete("`product`", "`ID`=$id");
	}

	public static function tt()
	{
		$data = data::selects('`product_category`', "");
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}


	public static function get_category()
	{
		//echo 'test';exit;
		$data = data::selects('`product_category`', "");
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}


	public static function get_product()
	{

		$data = data::selects('`product`', "");
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function get_product_categoryID($id)
	{
		$data = data::selects('`product`', "`category`=" . $id);
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

	public static function set_category($name)
	{
		data::insertinto("`product_category`", "`ID`, `Name`","NULL, '".$name."'");
	}

	public static function del_category($id)
	{
		data::delete("`product_category`", "`ID`=$id");
	}

	public static function get_category_ID($id)
	{
		$data = data::selects('`product_category`', "`ID`=" . $id);
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}
	public static function edit_bk_color($color)
	{
		data::update("`tblstyle`", "`style`='".$color."'","`ID`='1'");
	}

	public  static function get_bk_color()
	{
		$data = data::selects('`tblstyle`', "`ID`='1'");
		if (count($data[0]) != 0) {
			return $data;
		} else {
			return false;
		}
	}

}‍
*/