<main>
	<ul>
		<?php foreach ($fields['links'] as $data) { ?>
			<li><a href="<?php echo $data['link']; ?>"><?php echo $data['text']; ?></a></li>
		<?php } ?>
	</ul>
</main>
