<?php

$user = 'lruf_common';
$pass = 'win95sux';

try {
    $dbh = new PDO('mysql:host=mysql.lruf.com;dbname=lruf_data', $user, $pass);
    echo "HERE";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$stmt = $dbh->prepare("INSERT IGNORE INTO `yelp` (`url`, `city`) VALUES (?, ?)");

$url = isset($_GET['url']) ? $_GET['url'] : 'nil';
$city = isset($_GET['city']) ? $_GET['city'] : 'nil';

$stmt->execute(array($url, $city));