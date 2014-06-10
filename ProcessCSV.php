<?php

// Class ProcessCSV

class ProcessCSV {

	public $filename = '';

	public function __construct($filename) {
	    $this->filename = $filename;
	}

	public function parseCSV($delimiter = ',') {
	    if(!file_exists($this->filename) || !is_readable($this->filename))
	        return FALSE;

	    $header = NULL;
	    $data = array();
	    if (($handle = fopen($this->filename, 'r')) !== FALSE)
	    {
	        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
	        {
	            if(!$header)
	                $header = $row;
	            else
	                $parsedData[] = array_combine($header, $row);
	        }
	        fclose($handle);
	    }

	    // Drop first line in csv
	    unset($data[0]);
	    return $parsedData;
	}

	public function makeEntries($parsedData) {

		foreach ($parsedData as $entry) {
			$formatted = [];

			if (!empty($entry['Score'])) {
				
				foreach ($entry as $key => $value) {

					if (isset($entry['First Name'])) {
						$formatted['First Name'] = $entry['First Name'];
					}

					if (isset($entry['Last Name'])) {
						$formatted['Last Name'] = $entry['Last Name'];
					}

					if (isset($entry['Email Address'])) {
						$formatted['Email Address'] = $entry['Email Address'];
					}
				
					if (isset($entry['Score'])) {
						$formatted['Score'] = $entry['Score'];
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

function calcAVG($entries) {

	foreach ($entries as $entry) {
		foreach ($entry as $value) {
			$scores[] = $entry['Score'];
		}
	}

	$averageScore = number_format(array_sum($scores) / count($scores), 1, '.', '');

	return $averageScore;
}

function calcResponseRate($parsedData, $entries) {
	$responseRate = count($entries) / count($parsedData) * 100;
	return number_format($responseRate);
}


}

?>