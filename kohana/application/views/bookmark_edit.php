
<?php

if(count($bookmarks['items']) == 1):

$bookmark = array_shift($bookmarks['items']);
$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
$url_parts = ($url) ? parse_url($url) : false;
$active_tags = array();

?>
<script>
var fav_sub_tags = <?php echo json_encode($tags); ?>;
</script>
<form class="well" method="POST">
 	
	<h3>Edit Bookmark</h3>
 	
	<label>Title</label>
 	<?php echo Form::input('title', $bookmark['title_full'], array('class' => 'span9', 'id' => 'favsub-form-title')); ?>
 	
 	<label>URL - <?php echo HTML::anchor($url, 'Go', array('target' => '_blank')); ?></label>
 	<?php echo Form::input('url', $url, array('class' => 'span9', 'id' => 'favsub-form-url')); ?>
 	
 	<label>Content</label>
 	<?php echo Form::textarea('content', $bookmark['content'], array('rows' => 3, 'class' => 'span9')); ?>
 	
 	<ul class="tagit" name="bookmark_tags[]">
	<?php
		foreach($bookmark['tags'] as $tag)
		{
			$active_tags[] = strtolower($tag['name']);
			echo '<li>'.$tag['name'].'</li>';
		}
	?>
 	</ul>
 	
	<?php echo Form::hidden('return_url', $referrer); ?>
 	
 	<input type="submit" value="Edit Bookmark">
 	
</form>

<div class="well">

<h3>Suggested Tags</h3>
<?php 
$suggested_tag_count = 0;
if(isset($diffbot['result']->tags)): ?>
	<?php foreach($diffbot['result']->tags as $diff_tag):
		$diff_tag = preg_replace('/,/', '', $diff_tag);
	?>
		<?php if( ! in_array(strtolower($diff_tag), $active_tags)):
			$suggested_tag_count++;
		?>
			<button class="btn tag-add"><?php echo $diff_tag; ?></button>
		<?php endif; ?>
	<?php endforeach; ?>
	<br><br>
<?php endif; ?>
<?php if(isset($diffbot['result']->errorCode)):
		if($diffbot['result']->errorCode == '404' && ! in_array('404', $active_tags)):
			$suggested_tag_count++;
?>
		<button class="btn tag-add">404</button>
<?php   endif;
	  endif;
?>
<?php if($suggested_tag_count > 0): ?>
	<br><br>
	<button class="btn btn-primary tag-add-all">Add All</button>
<?php endif; ?>

<?php if(isset($diffbot['result']->title)): ?>
	<?php if($diffbot['result']->title != $bookmark['title_full']): ?>
	
<h3>Diffbot Title</h3>
<div class="well" id="diffbot-title"><?php echo $diffbot['result']->title; ?></div>
<button class="btn btn-primary diffbot-replace-title">Replace Title</button>

	<?php endif; ?>
<?php endif; ?>

<?php if(isset($diffbot['result']->resolved_url)): ?>
	<?php
		$diff_bot_url = Model_URL::cleanup($diffbot['result']->resolved_url);
		if($diff_bot_url != $url): ?>
	
<h3>Diffbot URL</h3>
<div class="well" id="diffbot-url"><?php echo $diff_bot_url; ?></div>
<button class="btn btn-primary diffbot-replace-url">Replace URL</button>

	<?php endif; ?>
<?php endif; ?>

<h3>Content<h3>
<?php if(isset($diffbot['result']->summary)): ?>
	<h4>Summary</h4>
	<br>
	<div><?php echo nl2br(htmlentities($diffbot['result']->summary)); ?></div>
	<br><br>
<?php endif; ?>

<?php if(isset($diffbot['result']->text)): ?>
	<h4>Text</h4>
	<br>
	<div><?php echo nl2br(htmlentities($diffbot['result']->text)); ?></div>
	<br><br>
<?php endif; ?>

<pre>
<?php print_r($diffbot); ?>
</pre>


</div>

<?php

endif;