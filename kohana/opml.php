<?php
echo "<pre>";
$xml = simplexml_load_file('google-reader-subscriptions-11-04-2011.xml');

$dsn = 'mysql:dbname=favsub;host=127.0.0.1';
$user = 'root';
$password = 'win95sux';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$feeds = array();

foreach($xml->body->outline as $key => $data)
{
	$data = (array) $data;
	
	if(isset($data['outline']))
	{
		$parent_name = $data['@attributes']['text'];

		foreach($data['outline'] as $data2)
		{
			$data2 = (array) $data2;
			$data2 = $data2['@attributes'];
			$data2['parent'] = $parent_name;
			$feeds[] = $data2;
		}
	} else {
		$data = $data['@attributes'];
		$data['parent'] = '';
		$feeds[] = $data;
	}
}

$stmt = $pdo->prepare('INSERT INTO feeds (`title`, `display_title`, `url`, `site_url`, `folder` ) VALUES ( ?, ?, ?, ?, ? )');
foreach($feeds as $feed) {
	print_r($feed);
//	$result = $stmt->execute(array($feed['title'], $feed['title'], $feed['xmlUrl'], $feed['htmlUrl'], $feed['parent']));
//	var_dump($result);
}

echo "</pre>";