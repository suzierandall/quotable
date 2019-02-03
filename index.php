<?php
	include_once('app/quote.php');
	$quoter = new Quote;
	$quote = $quoter->get_quote();
	$title = $quoter->get_title();
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Create a nonsense quote</title>
</head>
<body>
<div>
	<h2><?=$title?></h2>
	<p><?=$quote?></p>
</div>
</body>
</html>

