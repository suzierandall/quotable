<?php
	include_once('app/quote.php');
	$quoter = new Quoter;
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Create a nonsense quote</title>
</head>
<body>
<div>
	<h2>Hello <?=$quoter->get_name()?></h2>
	<p><?=$quoter->get_quote()?></p>
</div>
</body>
</html>

