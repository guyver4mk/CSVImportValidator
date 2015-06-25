<?php

include('lib/classes/csvImport.php');

$csv = new csvImport();


$return_array = array();


$csv_file =	$csv->csvstring_to_array(file_get_contents('includes/import.csv'), 0, ',','');

$i = intval(0);
foreach($csv_file as $row)
{
	$check = $csv->checkColNums($row);


	if($check['return']=="error")
	{
		$error = $check['errors'];
	}
	else
	{
		$error = "";
	}

	$return_array[] = array("row" => $i, "status" => $check['return'], "cols" => $check['cols'], "errors" => $error); 
	$i++;
}

var_dump($return_array);

//var_dump($csv_file);
exit;