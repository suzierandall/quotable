<?php
include_once('lib/dictionary.php');

function select_entry(array $entries): ?string {
	$max = count($entries) - 1;
	$index = rand(0, $max);
	return $entries[$index];
}

function select_entries(): ?string {	
	$rv = null;
	$entries = get_dictionary();
	$story = [];
	foreach ($entries as $entry) {
		$story[] = select_entry($entry);
	}	
	$rv = implode(' ', $story);

	return $rv;
}

function get_name() {
	return 'fish';
}

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Create a nonsense quote</title>
</head>
<body>
<div>
	<h2>Hello <?=get_name()?></h2>
	<p><?=select_entries()?></p>
</div>
</body>
</html>

