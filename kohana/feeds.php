<?php

include 'simplepie.inc.php';

// We'll process this feed with all of the default options.
$feed = new SimplePie();
 
// Set which feed to process.
$feed->set_feed_url('http://boingboing.net/rss.xml');
 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

function filter_xml($matches) {
    return trim(htmlspecialchars($matches[1]));
} 

//libxml_use_internal_errors(true);

echo "<br><br>";
echo "<pre>";
foreach ($feed->get_items() as $item):

	$content = $item->get_content();
	$clean_content = trim(htmlspecialchars($content));
	
	$dom = new DOMDocument;
	$dom->loadHTML($content);
	
	$sxe = simplexml_import_dom($dom);

	$result = $sxe->xpath('//a/@href');
	
	while(list( , $node) = each($result)) {
		echo '//a: '.$node,"\n";
	}
	
	/*
	echo $content;
	echo "<br><br>".PHP_EOL.PHP_EOL;
	
	$xc = simplexml_load_string($content);
	
	var_dump($xc);
	
	$result = $xc->xpath('//a');
	
	while(list( , $node) = each($result)) {
		echo '/a/b/c: ',$node,"\n";
	}
	*/
	
	
	echo "<hr><hr><hr>";
		
endforeach;

echo "</pre>";