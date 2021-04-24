<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    

        
        private $_id;
        

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    
        /*
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
        */
        
        public function authenticate()
        {
            $record=User::model()->findByAttributes(array('email'=>$this->username));  // here use Email as user name which comes from database
            if($record===null)
               {
                       $this->_id='user Null';
                                   $this->errorCode=self::ERROR_USERNAME_INVALID;
               }
            else if($record->password!== md5($this->password))            // here compare db password with passwod field
               {        $this->_id=$this->username;
                        $this->errorCode=self::ERROR_PASSWORD_INVALID;
               }
            /* else if($record['status']!=='ACTIVE')                //  here check status as Active in db
                   {        
                        $err = "You have been Inactive by Admin.";
                        $this->errorCode = $err;
                   }*/
        
            else
            {  
               $this->_id=$record->user_id;
                $this->setState('title', $record['first_name']);
                $this->errorCode=self::ERROR_NONE;

            }
                return !$this->errorCode;
        }
        
        public function getId()
        {
            return $this->_id;
        }
     
    
           
}