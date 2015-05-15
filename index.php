<?php
$array = array();

for ($i = 0; $i<1000; $i++){
	$array[]=rand(1000, 99999);
}

$memcache = new Memcache;
$memcache->connect('localhost',11211) or die("Could not connect");
$memcache->set('test',$array,false,100) or die("Failed to save");
$memcache->close();

file_put_contents('text.txt',serialize($array));

$time = microtime(1);
for($i = 0; $i < 10000; $i++){
	$array = unserialize(file_get_contents('text.txt'));
}
echo microtime(1)-$time;
echo "<br>";
$time = microtime(1);
$memcache = new Memcache;
$memcache -> connect('localhost',11211) or die("Could not connect");
for($i = 0; $i < 10000; $i++){
	$memcache ->get('test');
}
$memcache->close();
echo microtime(1)-$time;

