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
		//$headers .= 'Cc: '.$this->getCCEmail().'\''."\n";
		$headers .= 'Cc: '.$this->getCCEmail()."\n";
		$headers .= "MIME-Version: 1.0 \n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1 \n";
		
		$this->headers = $headers;
	
		
	}
	
	public function setHeadersNoCC()
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
	
	
	public function eventLogHeaders()
	{
		// Always set content-type when sending HTML email
		// More headers
		$headers = 'From: Event Log <ISOperationsCenter@uscellular.com>' . "\n";
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
	}
	
	public function sendEmailNoCC( $to, $from, $subject, $message)
	{	
		$this->setTo( $to);
		
		$this->setFrom( $from );
		
		$this->setSubject( $subject);
		
		$this->setMessage( $message );
		// set Headers
		$this->setHeadersNoCC();
		
		// send email
		$this->sendEmail();
	}

	public function sendEmailWithCC( $to, $from, $CC, $subject, $message)
	{	
		$this->setTo( $to);
		
		$this->setFrom( $from );
		
		$this->setCCEmail( $CC );
		
		$this->setSubject( $subject);
		
		$this->setMessage( $message );
		
		// set Headers
		$this->setHeaders();
		
		// send email
		$this->sendEmail();
	}
	// An Event is about to start in 15 minutes.  <--notificationMessage    $_SERVER['HTTP_HOST']
	
	

	public function eventLogHTMLEmailBody( $subject, $notificationMessage, $eventID, $startTime, $endTime, $actionRequired, $initiator, $reference, $serverIpName  )
	{
		// create email message
		$message = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>'.$subject.'</title>

			</head>

			<body bgcolor="#f2eded">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
			  <tr>
				<td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
					<tr>
					  <td valign="middle">
					  
					  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">'.$subject.'</div>
						
						</td>
					</tr>
					<tr>
					  <td align="center">&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="10%">&nbsp;</td>
							<td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>ISOC,</em></strong></font><br /><br />
										<font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
					



					
							  
					'.$notificationMessage.'<br />
					<br />
					<b><u>Event ID: '.$eventID.'</u></b><br />
					<br />
					<b>Start Time:</b>      '.$startTime.'<br /> 
					<b>End Time:</b>  '.$endTime.'<br />
					<b>Action Required:</b>'.$actionRequired.'<br />
					<b>Initiator:</b> '.$initiator.'<br />
					<b>Reference:</b>      '.$reference.'<br />
					<br />
					<br />
					<br />
					Please complete the task and mark the event complete,<br />
					Automated Message from the Event Log
							  
							  
						



						
						  
								<br />
								<br />
								<a href="http://'.$serverIpName.'/eventlog.php">ISOC Event Log</a>
							</font>
							
							</td>
							<td width="10%">&nbsp;</td>
						  </tr>
						  
						  
						  
						  <tr>
							<td>&nbsp;</td>
							<td align="right" valign="top"></td>
							<td>&nbsp;</td>
						  </tr>
						</table></td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  
					</tr>
					
				  </table></td>
			  </tr>
			</table>
			</body>
			</html>
					';
			
		$this->setTo( 'ISOperationsCenter@uscellular.com');
		
		$this->setFrom( 'ISOperationsCenter@uscellular.com' );
		
		$this->setSubject( $subject);
		
		$this->setMessage( $message );
		// set Headers
		$this->eventLogHeaders();
		
		// send email
		$this->sendEmail();
	}
	
}
?>
