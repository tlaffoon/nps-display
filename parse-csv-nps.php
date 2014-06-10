<?php
// parse-csv.php

$filename = '../data/week5.csv';

function calcAVG($scores) {

	foreach ($scores as $entries) {
		foreach ($entries as $entry) {
			$avg[] = $entries['Score'];
		}
	}

	return number_format(array_sum($avg) / count($avg), 1, '.', '');
}

function calcResponseRate($parsed, $entries) {
	$rate = (count($entries) / count($parsed)) * 100;
	return number_format($rate);
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
$rate = calcResponseRate($parsed, $entries);

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
		    <a class="navbar-brand"> Badlands Cohort | Promoter.io </a>
		</div>
	</div>
</div>

<div class="container">
	<h4 class="week"> Week 5 </h4>
</div>

<div class="container">
		<h4 class="rate"> Response Rate: <?= $rate ?>% </h4>
		<h4 class="score"> Average Score: <?= $averageScore ?> </h4>
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