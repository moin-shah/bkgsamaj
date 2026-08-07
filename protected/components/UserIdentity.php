<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		
        // check if login details exists in database
		//$record=DndAdmin::model()->findByAttributes(array('email'=>$this->username));
		$record = Yii::app()->db->createCommand("SELECT external_dnd_admin.*,partner_masters.slug,partner_masters.partner_source,stack_percent,conversion_rate,partner_masters.name as partner_name,partner_masters.partner_logo,partner_masters.partner_small_logo FROM external_dnd_admin LEFT JOIN partner_masters ON partner_masters.id = external_dnd_admin.partner_id WHERE external_dnd_admin.email = '{$this->username}'")->queryRow(); 
		
		  
		if(empty($record))
		{ 
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}

		else if($record['password']!==$this->password)
		{ 
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{  

			$this->setState('user_id', $record['id']);
			$this->setState('name', $record['username']);
			$this->setState('partner_name', $record['partner_name']);
			$this->setState('email',$record['email']);
			$this->setState('partner_slug',$record['slug']);
			$this->setState('partner_source',$record['partner_source']);
			$this->setState('stack_percent',$record['stack_percent']);
			$this->setState('conversion_rate',$record['conversion_rate']);
			$this->setState('partner_id',$record['partner_id']);
			$this->setState('partner_logo',$record['partner_logo']);
			$this->setState('partner_small_logo',$record['partner_small_logo']);
			$this->setState('is_admin',$record['is_admin']);
			$this->setState('is_crm_admin',$record['is_crm_admin']);
			$this->errorCode=self::ERROR_NONE;

		}

		return !$this->errorCode;
	}
	
}
