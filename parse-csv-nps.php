<?php
// parse-csv.php

$filename = '../data/week5.csv';

/* 1 */	// Email Address	
/* 2 */	// First Name	
/* 3 */	// Last Name	
/* 4 */	// GMTOFF	
/* 5 */	// CONFIRM_IP	
/* 6 */	// CC	
/* 7 */	// REGION	
/* 8 */	// LAST_CHANGED	
/* 9 */	// LONGITUDE	
/* 10*/	// MEMBER_RATING	
/* 11*/	// CONFIRM_TIME	
/* 12*/	// EUID	
/* 13*/	// LATITUDE	
/* 14*/	// TIMEZONE	
/* 15*/	// OPTIN_IP	
/* 16*/	// DSTOFF	
/* 17*/	// LEID	
/* 18*/	// Badlands	
/* 19*/	// Status	
/* 20*/	// Score	
/* 21*/	// Comment

// function parseCSV($filename) {
// 	$array = [];
// 	$handle = fopen($filename, 'r');
// 	while(!feof($handle)) {
// 		$row = fgetcsv($handle);
// 		if (!empty($row)) {
// 			$array[] = $row;
// 		}
// 	}
// 	return $array;   
// }

function parseCSV($filename, $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    // Drop first line in csv
    unset($data[0]);
    return $data;
}

function Test($parsed) {
	foreach ($rowNum as $array) {
		foreach ($array as $columnHeader => $value) {
			echo "<p> $columnHeader --> $value";
		}
	}
}

function makeEntries($parsed) {
	

	foreach ($parsed as $entry) {
		$formatted = [];

		if (!empty($entry['Score'])) {
			
			foreach ($entry as $key => $value) {

				if (isset($entry['Score']) && !empty($entry['Score'])) {
					$formatted['Score'] = $entry['Score'];
				}
			
				if (isset($entry['First Name'])) {
					$formatted['First Name'] = $entry['First Name'];
				}

				if (isset($entry['Last Name'])) {
					$formatted['Last Name'] = $entry['Last Name'];
				}

				if (isset($entry['Email Address'])) {
					$formatted['Email Address'] = $entry['Email Address'];
				}
			
				if (isset($entry['Comment'])) {
					$formatted['Comment'] = $entry['Comment'];
				}
			}
		}  

		$entries[] = $formatted;

	} 

	return $entries;
}

$parsed = parseCSV($filename);

$entries = makeEntries($parsed);

?>

<!DOCTYPE html>
<html>
<head>
	<title>NPS Report</title>
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
	<table class="table table-striped table-hover">
		<tr>
			<th>Score</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Comment</th>
		</tr>

		<tr>
			<? foreach ($entries as $entry) : ?>
				<? foreach ($entry as $value) : ?>
					<td><?= htmlspecialchars(strip_tags($value)) ?></td>
				<? endforeach; ?>
		</tr>
			<? endforeach; ?>
	</table>
</div>

</body>
</html>