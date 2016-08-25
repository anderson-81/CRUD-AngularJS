<?php

	class Token{
		
		public static function Generate(){
			
			session_start();
			$_SESSION['_token'] = hash('sha512', rand(100, 10000));
			echo $_SESSION['_token'];		
			
		}
		
	}
	
	Token::Generate();


?>