
<?php

if(count($bookmarks['items']) == 1):

$bookmark = array_shift($bookmarks['items']);
$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
$url_parts = ($url) ? parse_url($url) : false;
		
?>
<script>
var fav_sub_tags = <?php echo json_encode($tags); ?>;
</script>
<form class="well" method="POST">
 	
	<h3>Delete Bookmark</h3>
 	
	<label>Title</label>
 	<div><?php echo $bookmark['title_full']; ?></div>
 	
 	<label>URL</label>
 	<div><?php echo $url; ?></div>
 	
 	<br />
 	
 	<?php echo Form::hidden('return_url', $referrer); ?>
 	
 	<input type="submit" value="Delete Bookmark">
 	
</form>
<?php

endif;