<?php
	include_once('app/quote.php');
	$quote = new Quote;
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Create a nonsense quote</title>
</head>
<body>
<div>
	<h2><?=$quote->get_title()?></h2>
	<p><?=$quote->get_quote()?></p>
	<h2><?=$quote->get_title()?></h2>
	<p><?=$quote->get_quote()?></p>
	<h2><?=$quote->get_title()?></h2>
	<p><?=$quote->get_quote()?></p>
</div>
</body>
</html>

