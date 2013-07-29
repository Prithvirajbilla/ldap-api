<?php
function getDept( $homedirectory ){
    if (empty($homedirectory)) {
    return '';
}
    $anotherArray = (explode("/", strrev($homedirectory)));
    return strrev($anotherArray[1]);
}
class ldapAuth
{
	// LDAP settings
    private  $ldap_host = 'ldap.iitb.ac.in';
    private  $ldap_port = 389;
    private  $baseDN = 'dc=iitb,dc=ac,dc=in';
    private $ldap_id;
    private $pass;
    private $ldap_conn;
    private $search_result;
    private $info;
    public function __construct()
    {
   		$arguments = func_get_args(); 

	   switch(sizeof(func_get_args()))      
	   {
	    case 0: 
	        break; 
	    case 1: //One argument
	        $this->ldap_id = $arguments[0]; 
	        break;              
	    case 2:  //Two arguments
	        $this->ldap_id = $arguments[0];
	        $this->pass = $arguments[1]; 
	        break;            
	   }
	   $this->ldap_conn = @ldap_connect($this->ldap_host, $this->ldap_port);
       ldap_set_option($this->ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
       $this->search_result = @ldap_search($this->ldap_conn, $this->baseDN, 'uid=' . $this->ldap_id, array('dn', 'givenname', 'sn','employeenumber', 'mail', 'homedirectory'));
       $this->info = @ldap_get_entries($this->ldap_conn, $this->search_result);
    }
    public function getFirstName()
    {
    	if (!empty($this->search_result))
    	{
    		$info = @ldap_get_entries($this->ldap_conn, $this->search_result);
    		if (isset($info[0]['givenname'][0]))
    		{
    			$user_fname = $info[0]['givenname'][0];
    			return $user_fname;
    		}
    		
    	}
    }
    public function getLastName()
    {
    	if (!empty($this->search_result))
    	{
    		$info = ldap_get_entries($this->ldap_conn, $this->search_result);
    		if (isset($info[0]['sn'][0]))
    		{
        		$user_lname = $info[0]['sn'][0];
    			return $user_lname;
    		}
    	}

    }
    public function getRollNo()
    {
    	if (!empty($this->search_result))
    	{
    		$info = ldap_get_entries($this->ldap_conn, $this->search_result);
    		if(isset($info[0]['employeenumber'][0]))
    		{
	    		$rollno = $info[0]['employeenumber'][0];
	    		return $rollno;
	    	}
    	}
    }

    public function getMail()
    {
    	if (!empty($this->search_result))
    	{
    		$info = ldap_get_entries($this->ldap_conn, $this->search_result);
    		if(isset($info[0]['mail'][0]))
    		{
        		$mail = $info[0]['mail'][0];
    			return $mail;
    		}
    	}

    }
    public function getDept()
    {
    	if (!empty($this->search_result))
    	{
    		$info = ldap_get_entries($this->ldap_conn, $this->search_result);
    		if(isset($info[0]['homedirectory'][0]))
    		{
    			$dept = getDept($info[0]['homedirectory'][0]);
    			return $dept;
    		}
    	}
    }
    public function getSearchResult()
    {
    	return $this->search_result;
    }
    public function getInfo()
    {
    	return $this->info;
    }
    public function bind($pass)
    {
        $this->pass = $pass;
        $info = ldap_get_entries($this->ldap_conn, $this->search_result);
    	if(isset($info[0]['dn']))
    	{	
        	$user_dn = $info[0]['dn'];
    		$bind_result = @ldap_bind($this->ldap_conn, $user_dn, $this->pass);
    		return $bind_result;
    	}
        else
        {
            return false;
        }
    }

}



?>
