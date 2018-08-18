<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name ="viewport" content="width=device-width, initial-scale=1.0" >
		<link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<script src="https://use.fontawesome.com/e86aa14892.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/main.css"/>
		<script src="{$HOME}{$JS_SCRIPTS}main.js"></script>
		{block name="head"}{/block}
		{$facebook_pixel|default:null}
	</head>
	<body>
		{block name="body"}{/block}
	</body>
	<footer>
		{block name="footer"}{/block}
	</footer>
</html>
