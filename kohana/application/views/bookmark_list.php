	<ul class="pager">
		<?php if($bookmarks['item_page'] != 1): ?>
    	<li class="previous">
    		<?php
    			$prev_get = $_GET;
    			if(isset($prev_get['page'])) {
    				if($prev_get['page'] == 2)
    				{
    					unset($prev_get['page']);
    				}
    				else
    				{
    					$prev_get['page']--;
    				}
    			}
    			echo HTML::anchor('bookmarks?'.http_build_query($prev_get), '&larr; Newer');
    		?>
	    </li>
	    <?php endif; ?>
	    <li>
	    	Found <?php echo number_format($bookmarks['item_found_count']). ' item'; if($bookmarks['item_found_count'] > 1) { echo 's'; } ?>
	    </li>
	    <?php if($bookmarks['item_page'] < $bookmarks['item_page_count']): ?>
    	<li class="next">
    		<?php
    			$next_get = $_GET;
    			if(isset($next_get['page'])) {
    				$next_get['page']++;
    			}
    			else
    			{
    				$next_get['page'] = 2;
    			}
    			echo HTML::anchor('bookmarks?'.http_build_query($next_get), 'Older &rarr;');
    		?>
	    </li>
	    <?php endif; ?>
    </ul>
<?php
	$date_bar = '';
	
	foreach($bookmarks['items'] as $bookmark): ?>
	<?php
		$url = (isset($bookmarks['urls'][$bookmark['item_url_id']])) ? $bookmarks['urls'][$bookmark['item_url_id']]['url'] : false;
		$url_parts = ($url) ? parse_url($url) : false;
		
		$ref_url = (isset($bookmarks['urls'][$bookmark['ref_url_id']])) ? $bookmarks['urls'][$bookmark['ref_url_id']]['url'] : false;
		
		$item_date = strtotime($bookmark['entered_date']);
		$item_display_date = date('M jS, Y', $item_date);
		$item_display_time = date('g:i a', $item_date);
		$item_link_time = date('H:i', $item_date);
	?>
	<?php if($item_display_date != $date_bar): ?>
	<div class="lruf-date-bar">
		<h2><?php echo $item_display_date; ?></h2>
	</div>
	
	<?php 
			$date_bar = $item_display_date;
		endif;
	?>
	<div class="lruf-item">
		<div class="pull-right">
		<?php $edit_icon = ($do_process) ? 'icon-pencil' : 'icon-eye-open'; ?>
			<?php echo HTML::anchor('bookmarks/edit/'.$bookmark['id'].'-'.URL::title($bookmark['title_full']), '<i class="'.$edit_icon.'"></i>'); ?>
			<?php if($do_process): ?>
			|
			<?php echo HTML::anchor('bookmarks/delete/'.$bookmark['id'], '<i class="icon-remove"></i>'); ?>
			<?php endif; ?>
		</div>
		<h3><?php echo HTML::anchor($url, '<i class="icon-share"></i>', array('target' => '_blank', 'rel' => 'nofollow')); ?> <?php echo HTML::anchor('bookmarks/edit/'.$bookmark['id'].'-'.URL::title($bookmark['title_full']), $bookmark['title_full']); ?></h3>
		<small>( <?php echo $url_parts['host']; ?>)</small>
		<div><?php /* echo $bookmark['content']; */ ?></div>
		
		<?php if(count($bookmark['tags']) > 0): ?>
		<div class="pull-left lruf-tags">
		Tags: 
		<?php foreach($bookmark['tags'] as $tag): ?>
			<?php echo HTML::anchor('bookmarks/tag/'.$tag['name'], '<span class="label">'.$tag['name'].'</span>'); ?>
		<?php endforeach; ?>
		</div>
		<?php endif; ?>
		
		<div class="pull-right">
			<?php echo HTML::anchor('bookmarks/on_time/'.$item_link_time, $item_display_time); ?>
		</div>
		<!--
		<div class="well">
			<pre>
			<?php print_r($bookmark); ?>
			</pre>
		</div>
		-->
		<div>&nbsp;</div>
		<hr>
	</div>
	
	<?php endforeach; ?>
	
	<?php echo $paging->render(); ?>