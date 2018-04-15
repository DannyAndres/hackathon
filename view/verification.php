<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="index.php" method="post">
	 <a target="_blank" href="<?= $authUrl ?>"><?php echo $authUrl; ?></a>
	 <p>Enter verification code: <input type="text" name="code" /></p>
	 <p><input type="submit" /></p>
	</form>
	<hr>
	CODIGO: <?php echo htmlspecialchars($_POST['code']); ?>
</body>
</html>