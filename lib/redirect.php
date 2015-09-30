<?php

					if(isset($_POST))
					{
						header('location: /supportrequestform.php');
						unset($_POST);
					}

?>