<?php 
require_once 'Class_BaseDataBase.php';

class ValidationUserInput extends BaseDataBase
{
	private $errorContainer;

	// Constructor
	function ValidationUserInput()
	{
		$this->instantiateVariables();
	}
	// Instantiate Variables used in this class
	private function instantiateVariables()
	{		
		 $this->errorContainer = array();
	}
	
	private function addToErrorArray( $nameOfObject )
	{
		// add to errorContainer Array
		$this->errorContainer[] = $nameOfObject;		
	}
	
	private function sanitize_input($astring)
	{
		 $astring = trim($astring);
		 $astring = stripslashes($astring);
		 $astring = htmlspecialchars($astring);
		 $astring =  parent::getDbConnection()->real_escape_string( $astring );
		 return $astring;
	}
	
	/*
	* @param: string $nameOfObject
	*                The string is the name of an html element.
	* @return:
	*         returns a boolean , true or false.
	*         returns false when the html element does not have data in the $_POST variable and when it does not pass validation.
	*         returns true when the html object passes validation and when data is in the $_POST variable.
	* @summary: 
	*/
	private function check_POST ( $nameOfObject )
	{
		
		if ( ! empty($_POST[ $nameOfObject ] ) )
		{
			return true;  // passed post and validation
			
		}
		else
		{
			return false;  // Did not pass validation
		}	
	}
	
	private function validateAllCharaters( $nameOfObject )
	{
		
		if ( $this->check_POST($nameOfObject) && preg_match("/^[a-zA-Z0-9@.]*$/",$_POST[$nameOfObject]) )
		{
			// Calls sanitize function and then saves results in the name box variable located in this class.
			$_POST[$nameOfObject] = $this->sanitize_input($_POST[$nameOfObject]);
			return true; // pass validation
		}
		else
		{
			
			$this->addToErrorArray( $nameOfObject);
			return false; // failed validation
		}
	}
		
	private function validateLettersOnly ($nameOfObject )
	{
		
		if ( $this->check_POST($nameOfObject) && preg_match("/^[a-zA-Z ]*$/",$_POST[$nameOfObject]) )
		{
			// Calls sanitize function and then saves results in the name box variable located in this class.
			$_POST[$nameOfObject] = $this->sanitize_input($_POST[$nameOfObject]);
			return true; // pass validation
		}
		else
		{
			
			$this->addToErrorArray( $nameOfObject);
			return false; // failed validation
		}
	}
	
	private function validateEmail( $nameOfObject )
	{
		// Perform Data Sanitization on Email from User.
	
			// Calls sanitize function and then saves results in the name box variable located in this class.
				
			if ( $this->check_POST($nameOfObject) && filter_var($_POST[$nameOfObject], FILTER_VALIDATE_EMAIL) === true) 
			{
				 $_POST[$nameOfObject] = $this->sanitize_input($_POST[$nameOfObject]);
				return true;  // pass validation
			} 
			else 
			{
				$this->addToErrorArray( $nameOfObject);
				return false;  // fail validation
			}
		
	}
	
	private function validateIntegers( $nameOfObject )
	{
		// Perform Data Sanitization on Email from User.
	
			// Calls sanitize function and then saves results in the name box variable located in this class.
				
			if ( $this->check_POST($nameOfObject) && filter_var($_POST[$nameOfObject], FILTER_VALIDATE_INT) === true) 
			{
				 $_POST[$nameOfObject] = $this->sanitize_input($_POST[$nameOfObject]);
				return true;  // pass validation
			} 
			else 
			{
				$this->addToErrorArray( $nameOfObject);
				return false;  // fail validation
			}
		
	}
	
	private function validateUSAPhoneNumber ( $nameOfObject )
	{
		// Perform Data Sanitization on the Contact Number box
	
			// Calls sanitize function and then saves results in the numberbox variable located in this class.
				// Checks the length of the string and also ensures the data is only numbers
		if ( $this->check_POST($nameOfObject) && ( strlen($_POST[$nameOfObject]) == 10 || strlen($_POST[$nameOfObject]) == 9) && preg_match('/^\d+$/',$_POST[$nameOfObject]) )
		{
			$_POST[$nameOfObject] = $this->sanitize_input($_POST[$nameOfObject]);
			return true; // pass validation
		}
		else
		{
			$this->addToErrorArray( $nameOfObject);
			return false; // failed validation
		}
	}
	
	private function validateMultipleEmails( $nameOfObject )
	{
		// Calls sanitize function and then saves results in the name box variable located in this class.
					
		// get email addresses from post variable
		$emails = $_POST[$nameOfObject];
				
		// separate each value with a comma to an array.
		$explode = explode(',',$emails); // Explodes the emails by the comma
				
		// Loop through each email and validate it
		foreach($explode as $email) 
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
			{
				// successful yeah.. do nothing.
			} else 
			{
					$this->addToErrorArray( $nameOfObject);
					return false;  // failed validation
			}
		}

		// take array and place in one string
		$tmp = implode(", ",$explode);
				
		// Sanitize
		$_POST[$nameOfObject] = $this->sanitize_input($tmp);
		return true;  // pass validation
	}
	
	
	
   /*
	* @param: string $nameOfObject 
	*                 The string is the name of an html element.
	*
	* @return: string (text)
	*                 The string places the word error in the class tag of an html object if the name of the object
	*                 is located in the errorContainer array.
	*
	* @summary:    This function adds the text error to the class field of an html object if the html object doesn't 
	*              pass valication.  The error text is a class in bootstrap CSS and highlights the textbox in red.
	*/               
	public function input_error( $nameOfObject )
	{
		foreach ( $this->errorContainer as &$value)
		{
			if ($value == $nameOfObject)
			{
				echo 'error';
				return; // end execution of loop
			}
		}
	}
	
	
	
	public function validateInformation( $nameOfObject, $aType )
	{
		// Make type all upper-case
		$aType = strtoupper( $aType );
		
		switch ($aType) 
		{
			case "LETTER":
					return $this->validateLettersOnly( $nameOfObject );
				break;
			case "EMAIL":
					return $this->validateEmail( $nameOfObject );
				break;
			case "EMAILS":
					return $this->validateMultipleEmails( $nameOfObject );
			case "INT":
					return $this->validateIntegers( $nameOfObject );//******************
			case "USAPHONE":
					return $this->validateUSAPhoneNumber( $nameOfObject );
			case "ALL":
					return $this->validateAllCharaters( $nameOfObject );//******************
				break;
			default:
					return $this->validateAllCharaters( $nameOfObject );
		}	
	}
}
?>