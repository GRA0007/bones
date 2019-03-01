<?php
function nl2p($text) {
    return '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $text).'</p>';
}

function image_link($file) {
	global $home_url;

	return $home_url . '/res/img/' . $file;
}

function internal_link($link) {
	global $home_url;

	return $home_url . $link;
}
