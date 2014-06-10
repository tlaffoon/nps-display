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

function calcAVG($scores) {

	foreach ($scores as $entries) {
		foreach ($entries as $entry) {
			$avg[] = $entries['Score'];
		}
	}

	return number_format(array_sum($avg) / count($avg), 2, '.', '');
}

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

function makeEntries($parsed) {

	foreach ($parsed as $entry) {
		$formatted = [];
		$nonrespondents = [];

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

		if (!empty($formatted)) {
			$entries[] = $formatted;
		}	
	} 

	return $entries;
}

$parsed = parseCSV($filename);

$entries = makeEntries($parsed);

$averageScore = calcAVG($entries);

?>

<!DOCTYPE html>
<html>
<head>
	<title>NPS Report</title>
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="./bootstrap/css/custom.css" rel="stylesheet">
</head>
<body>

<div class="navbar">
	<div class="container-fluid">
		<div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		        <a class="navbar-brand" href="http://nps.dev/">Badlands Cohort | Promoter.io</a>
		      </div>
		      
		      <form class="navbar-form navbar-right" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">Submit</button>
		      </form>
	</div>
</div>

<div class="container">
	<h4 class="week"> Week 5 </h4>
	<h4 class="score"> Average Score: <?= $averageScore ?></h4>
</div>

<div class="container">
	<table class="table table-striped">
		<tr>
			<th>Score</th>			
			<th>First</th>
			<th>Last</th>
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