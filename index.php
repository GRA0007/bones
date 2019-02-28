<?php
$htaccess = fopen('.htaccess', 'w+');
fwrite($htaccess, 'RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ ' . $_SERVER['SCRIPT_NAME'] . ' [L,QSA]');
fclose($htaccess);


$path = str_replace(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
$path_components = explode('/', $path);
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<strong>Request URI:</strong> <?php echo $path; ?>

		<pre><?php print_r($path_components); ?></pre>
	</body>
</html>
