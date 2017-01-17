<?php

class UserData{

	private $id;
	private $password;
	private $phone_number;
	private $activated;
	private $fname;
	private $lname;
	private $date_reg;

	public function __construct( $id = null ){
		if( $id != null ){
			$arr = ObjectDB::loadObject( "UserData", $id );
			foreach ( $arr as $key => $value ) {
				$this->$key = $value;
			}
		}
	}
}