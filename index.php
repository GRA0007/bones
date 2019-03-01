<?php
require_once('vendor/autoload.php');
require_once('bones/php/render_functions.php');

$htaccess = fopen('.htaccess', 'w+');
fwrite($htaccess, 'RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ ' . $_SERVER['SCRIPT_NAME'] . ' [L,QSA]');
fclose($htaccess);

$config = Spyc::YAMLLoad('config.yaml');

$path = rtrim(str_replace(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']), '/');
$path_components = explode('/', $path);

$home_url = dirname($_SERVER['SCRIPT_NAME']);
if ($home_url == '/') {
	$home_url = '';
}

$page_name = $config['default_page'];
if ($path != '')
	$page_name = $path;

if (!file_exists('pages/' . $page_name . '.yaml')) {
	http_response_code(404);
	exit;
}

$page = Spyc::YAMLLoad('pages/' . $page_name . '.yaml');

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

		<link rel="stylesheet" href="<?php echo $home_url; ?>/res/css/<?php echo $config['main_css']; ?>" />
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
		foreach ($page['content'] as $module_name => $data) {
			$module_name = preg_replace('/\[.*?\]/', '', $module_name);
			$module = Spyc::YAMLLoad('modules/' . $module_name . '.yaml');
			$fields = preprocess($module_name, $data, $module);
			include('modules/templates/' . $module['template']);
		}
		?>
	</body>
</html>
