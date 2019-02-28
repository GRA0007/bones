<?php
require_once('vendor/autoload.php');

$htaccess = fopen('.htaccess', 'w+');
fwrite($htaccess, 'RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ ' . $_SERVER['SCRIPT_NAME'] . ' [L,QSA]');
fclose($htaccess);

$config = Spyc::YAMLLoad('config.yaml');

$path = str_replace(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
$path_components = explode('/', $path);

$page = Spyc::YAMLLoad('pages/' . $config['default_page'] . '.yaml');

$page_title = $page['meta']['title'];
if ($path != '') {
	$page_title = $page['meta']['title'] . ' ' . $config['title_suffix'];
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<meta name="description" content="<?php echo $page['meta']['description']; ?>">

		<link rel="stylesheet" href="res/css/<?php echo $config['main_css']; ?>" />
		<style><?php
		foreach ($page['content'] as $module_name => $fields) {
			if (file_exists('res/css/' . $module_name . '.css'))
				include('res/css/' . $module_name . '.css');
		}
		?></style>
	</head>
	<body>
		<pre style="display:none;"><?php print_r($path_components); ?></pre>

		<?php
		foreach ($page['content'] as $module_name => $fields) {
			$module = Spyc::YAMLLoad('modules/' . $module_name . '.yaml');
			include('modules/templates/' . $module['template']);
		}
		?>
	</body>
</html>
