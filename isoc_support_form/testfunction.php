<?php

		$anArray = array("Volvo", "BMW", "Toyota");
		//$questionMarks = array();
		$values = array_values($anArray);
		
		$fields = array_keys($anArray);
		
		// create an array for the number 
		for ($x=0; $x < count($fields); $x++)
		{
			$questionMarks[$x] = '?';
			$bindingTypes[$x] = 's';
			$variableNames[$x] = '$values['.$x.']' ;
		}
		
		//print_r($questionMarks);
		$numberOfQuestionMarks = array_keys($questionMarks);
		
		
		/*
		foreach ($fields as $aValue)
		{
			$questionMarks[] = '?';
		}
		*/
		
		
		$sql = "INSERT INTO `TB_SUPPORT_FORM_DATA` (".implode( "," , $fields ).") VALUES (".implode( "," , $questionMarks )." )";
		$bind = "'" . implode( "" , $bindingTypes ) . "' , ".implode( ',' , $variableNames ) ;

		echo $bind;



?>