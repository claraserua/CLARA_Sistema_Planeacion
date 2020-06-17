<?php
require 'permisos.php';

class RolesUsuario extends Permisos
{
    var $roles;
	var $user_id;

    //Constructos
	function RolesUsuario($username) {
        $this->user_id = $username;
        $this->initRoles();
    }


    function getByRolesUsername($username) {
              
                       
    }

    // Asociamos los roles con los permisos
    function initRoles() {
        
		$user = $this->user_id;
		$this->roles = array();
        $sql = "SELECT R.PK1,R.ROLE 
                    FROM PL_ROLES R, PL_ROLES_USUARIO RU 
                    WHERE RU.PK_ROLE = R.PK1 AND
                    RU.PK_USUARIO = '$user'";
	  
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
			$this->roles[$row["PK1"]] = new Permisos($row["PK1"]) ;	
			
		}
		
	 
    
    }

    // checamos si el usuario tiene permiso
    function hasPrivilege($perm) {
		
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}
?>