<?php
class ISOC_EMAIL
{
	private $to;
	private $from;
	private $subject;
	private $message;
	private $headers;
	private $ccEmail;
	

	function Class_ISOC_EMAIL()
	{
		$this->instantiateVariables();
	}

	private function instantiateVariables()
	{
		$this->to = "";
		$this->setFrom( 'ISOperationsCenter@uscellular.com');
		$this->subject = "";
		//$this->message = "";
		$this->setMessage();
		//$this->headers = "";
		$this->setHeaders();
		$this->ccEmail = "";
	}
	
	public function setTo( $to )
	{
		$this->to = $to ;
	}
	
	public function setFrom( $from )
	{
		$this->from = $from ;
		
	}
	
	public function setSubject( $subject )
	{
		$this->subject = $subject;
	}

	public function setMessage( $message = "" )
	{
        if (!isset($message) )
		{
			$this->message = "
			
			<html>
			<head>
			<title>HTML email</title>
			</head>
			<body>
			<p>This email contains HTML Tags!</p>
			<table>
			<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			</tr>
			<tr>
			<td>John</td>
			<td>Doe</td>
			</tr>
			</table>
			</body>
			</html>
			";
		}
		else
		{
			$this->message = $message;
		}
	}
	
	public function setCCEmail( $ccEmail )
	{
		$this->ccEmail = $ccEmail;
	}
	
	public function setHeaders(  )
	{
		
		// Always set content-type when sending HTML email
		
		// More headers
		$headers = 'From: '.$this->getFrom()."\n";
		//$headers .= 'From: IS Operations <ISOperationsCenter@uscellular.com>' . "\n";
		$headers .= "Reply-To: ".$this->getFrom()."\n";
		$headers .= 'Cc: '.$this->getCCEmail().'\''."\n";
		$headers .= "MIME-Version: 1.0 \n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1 \n";
		
		$this->headers = $headers;
	
		
	}
	
	public function setHeadersNoCC(  )
	{
		
		// Always set content-type when sending HTML email
		
		// More headers
		$headers = 'From: '.$this->getFrom()."\n";
		//$headers .= 'From: IS Operations <ISOperationsCenter@uscellular.com>' . "\n";
		$headers .= "Reply-To: ".$this->getFrom()."\n";
		$headers .= "MIME-Version: 1.0 \n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1 \n";
		
		$this->headers = $headers;
	
		
	}
	
	
	public function getFrom()
	{
		return $this->from;
	}

	public function getCCEmail()
	{
		return $this->ccEmail;
	}
	
	public function sendEmail()
	{
		mail($this->to,$this->subject,$this->message,$this->headers);
			echo "Email has been sent";
	}



}
?>
