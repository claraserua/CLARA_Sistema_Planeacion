<?php



class Session
{
	
	
	function setSession($user,$titulo,$nombre,$apellidos,$email,$imagen,$nodo) {
	     
	$_SESSION['session'] = array('user'=>$user,'titulo'=>$titulo,'nombre'=>$nombre,'apellidos'=>$apellidos,'email'=>$email,'sessionid'=>'1212','imagen'=>$imagen,'nodo'=>$nodo);
	return $_SESSION['session'];
		
	}
	
	
	// function _constructor($cookie="1",$only_cookies="0",$sid="1",$session="passport"){
	

		
	//}
	

	
	function configSession(){
		
    ini_set("session.use_cookies", 1);
    ini_set("session.use_only_cookies", 0);
    ini_set("session.use_trans_sid", 1);
    ini_set("url_rewriter.tags", "a=href,form=fakeentry");
    define("SESION", "sesionCookieUrl");
    session_name(SESION);
	
	}
	



	/**
	 * Called at end-of-page to save the current session data to the session cookie
	 *
	 * return boolean
	 */
	 function save($name = 'session')
	{
		return Cookie::set($name, $_SESSION);
	}


	/**
	 * Destroy the current users session
	 */
      function destroy($name = 'session')
	{
		//Cookie::set($name, '');
		//unset($_COOKIE[$name], $_SESSION);
	}


	/**
	 * Create new session token or validate the token passed
	 *
	 * @param string $token value to validate
	 * @return string|boolean
	 */
	
     function token($token = NULL)
	{
	
	}

}

// END
