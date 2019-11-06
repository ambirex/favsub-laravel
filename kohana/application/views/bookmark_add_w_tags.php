<?php if(isset($tags)): ?>
<script>
var fav_sub_tags = <?php echo json_encode($tags); ?>;
</script>
<?php endif; ?>

<div>
	<h2>Bookmark Saved</h2>
	
	<form class="well">
	
	<label>Add Some Tags</label>
	<ul class="tagit" name="bookmark_tags[]">
	<?php
		foreach($add_tags as $tag)
		{
			echo '<li>'.$tag.'</li>';
		}
	?>
	</ul>
	
	<input type="submit">
	</form>
</div>