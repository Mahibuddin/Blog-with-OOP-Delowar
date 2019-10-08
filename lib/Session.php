<?php
	/**
	 * Session Class
	 */
	class Session{
		
		public static function init(){
			session_start();
		}

		public static function set($key, $value){
			$_SESSION[$key] = $value;
		}

		public static function get($key){
			if (isset($_SESSION[$key])) {
				return $_SESSION[$key];
			}else{
				return false;
			}
		}

			// Check Session For Each Page When login.....

		public static function checkSession(){
			self::init();
			if (self::get('login') == false) {
				self::destroy();
				header("Location:login.php");
			}
		}

					// Check Session When page login, when page login page redirect to index page.....

		public static function checkLogin(){
			self::init();
			if (self::get('login') == true) {
				header("Location:index.php");
			}
		}

			// Destroy for Login false.....

		public static function destroy(){
			session_destroy();
			header("Location:login.php");
		}


	}
?>