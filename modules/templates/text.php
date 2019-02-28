<?php
function nl2p($text) {
    return '<p>'.str_replace(array("\r\n", "\r", "\n"), '</p><p>', $text).'</p>';
}
?>

<main>
	<?php echo nl2p($fields['body']); ?>
</main>
