<?php

if(count($bookmarks['items']) == 1):

$bookmark = array_shift($bookmarks['items']);
$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
$url_parts = ($url) ? parse_url($url) : false;
$active_tags = array();

$show_youtube = FALSE;
$youtube_id = FALSE;

if($url_parts['host'] == 'www.youtube.com' || $url_parts['host'] == 'youtube.com') {
	if(isset($url_parts['query'])) {
		parse_str($url_parts['query'], $url_query);
		if(isset($url_query['v'])) {
			$show_youtube = TRUE;
			$youtube_id = $url_query['v'];
		}
	}
}

?>
<script>
var fav_sub_tags = <?php echo json_encode($tags); ?>;
</script>
<div class="well">
 	
	<h3><?php echo HTML::anchor($url, $bookmark['title_full'], array('target' => '_blank')); ?></h3>
	
	<?php if($show_youtube): ?>
	<div>
	<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe>
	</div>
	<?php endif; ?>

 	<?php if(!empty($bookmark['content'])): 
 		echo '<div>'.$bookmark['content'].'</div>';
 	endif; ?>
 	
 	<?php if(isset($diffbot['result']->summary)): ?>
	<br>
	<div><?php echo nl2br(htmlentities($diffbot['result']->summary)); ?></div>
	<br>
	<?php endif; ?>

<?php if(FALSE): ?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6457690957209905";
/* FavSub-HorzMed-468x15 */
google_ad_slot = "6590433353";
google_ad_width = 468;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php endif; ?>

<?php if(isset($show_ad)): ?>
<?php if($show_ad): ?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- FavSub-Responsive-Detail -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6457690957209905"
     data-ad-slot="9364701138"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php endif; ?>
<?php endif; ?>

<br><br>
 	<div class="pull-left lruf-tags">
		Tags: 
	<?php
		foreach($bookmark['tags'] as $tag)
		{
			$active_tags[] = strtolower($tag['name']);
			echo HTML::anchor('bookmarks/tag/'.$tag['name'], '<span class="label">'.$tag['name'].'</span>').'&nbsp;';
		}
	?>
 	</div>
 	
 	<div>&nbsp;</div><div>&nbsp;</div>
 	
 	<?php if(count($related) > 0): ?>
 	<div>
 	<h4>Related Links:<h4>
 	<ul>
 	<?php foreach($related['items'] as $ritem): ?>
 		<li><?php echo HTML::anchor('bookmarks/edit/'.$ritem['id'].'-'.URL::title($ritem['title_full']), $ritem['title_full']); ?></li>
 	<?php endforeach; ?>
 	<ul>
 	</div>
 	<?php endif; ?>
</div>

<div class="well">

<?php if(isset($diffbot['result']->resolved_url)): ?>
	<?php
		$diff_bot_url = Model_URL::cleanup($diffbot['result']->resolved_url);
		if($diff_bot_url != $url): ?>
	
<h3>Original URL</h3>
<div class="well" id="diffbot-url"><?php echo $diff_bot_url; ?></div>

	<?php endif; ?>
<?php endif; ?>

<h3>Content<h3>

<?php if(isset($diffbot['result']->text)): ?>
	<h4>Cached Text (at the time of saving)</h4>
	<br>
	<div><?php echo Text::auto_p($diffbot['result']->text); ?></div>
	<br><br>
<?php endif; ?>

</div>

<?php

endif;