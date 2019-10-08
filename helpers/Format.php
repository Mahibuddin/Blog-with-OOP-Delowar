<?php

	/**
	 * 
	 */
	class Format{

			// Time Frmat ......

		public function formatDate($date){
			return date('M j, Y, g:i a', strtotime($date));
		}

			// Blog Post Excerpt ......

		public function textShorten($text, $limit = 400){  // Excerpt post er jonno
			$text = $text. " ";
			$text = substr($text, 0, $limit); // Excerpt post limit er jonno
			$text = substr($text, 0, strrpos($text, ' ')); //space porjonto or complete word paoyar jonno.
			$text = $text. " ...";
			return $text;
		}

			// Login Validation ......

		public function validation($data){
			$data =trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

					// Dynamic Page & Post Title ......

		public function title(){
			$path  = $_SERVER['SCRIPT_FILENAME'];   // 'SCRIPT_FILENAME' The absolute pathname of the currently executing script.....      
			$title = basename($path, '.php');
			// $title = str_replace('_', ' ', $title)
			if ($title == 'index') {
				$title = 'home';
			}elseif ($title == 'contact') {
				$title = 'contact';
			}
			return $title = ucfirst($title);

			// if use like contact_us.php then put $title = str_replace('_','',$title); after between function
			// and should be used ucwords....
		}
 


	}