<div class="item-list-cont">
	<?php
		$date_bar = '';
	?>
	<?php foreach($bookmarks['items'] as $bookmark): ?>
		<?php
			$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
			$ref_url = (isset($bookmarks['urls'][$bookmark['ref_url_id']])) ? $bookmarks['urls'][$bookmark['ref_url_id']]['url'] : false;
			$item_date = strtotime($bookmark['entered_date']);
			$item_display_date = date('F jS, Y', $item_date);
		?>
		<?php if($item_display_date != $date_bar): ?>
		<div class="item-date-bar">
			<?php echo $item_display_date; ?>
			<hr />
		</div>
		<?php 
				$date_bar = $item_display_date;
			endif;
		?>
		<div class="item-cont">
			<div class="item-link">
			<?php echo ($url) ? HTML::anchor($url, $bookmark['title_full']) : $bookmark['title_full']; ?>
			</div>
			<pre><?php print_r($bookmark); ?></pre>
		</div>
	<?php endforeach; ?>
</div>