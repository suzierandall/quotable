<?php
	include_once('app/quote.php');
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Create a nonsense quote</title>
</head>
<body>
<div>
	<h2>Hello <?=Quote::get_name()?></h2>
	<p><?=Quote::get_quote()?></p>
</div>
</body>
</html>

