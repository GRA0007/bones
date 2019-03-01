<nav>
	<?php foreach ($fields['links'] as $data) { ?>
		<a href="<?php echo $data['link']; ?>"><?php echo $data['text']; ?></a>
	<?php } ?>
</nav>
