<?php
// parse-csv.php

include('./ProcessCSV.php');

$objectOne = new ProcessCSV('../data/week5.csv');

$parsedData = $objectOne->parseCSV();

$entries = $objectOne->makeEntries($parsedData);

$averageScore = $objectOne->calcAVG($entries);

$rate = $objectOne->calcResponseRate($parsedData, $entries);

// $parsed = parseCSV($filename);
// $entries = makeEntries($parsed);
// $averageScore = calcAVG($entries);
// $rate = calcResponseRate($parsed, $entries);

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

<div class="container-fluid">
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