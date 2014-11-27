<?php
require_once('fcache.inc.php');
//example
$cache = new FCache();

$storeData = array(
      'time'   => time(),
      'str' => 'test',
      'int'   => 1321
);
$cache->add('select * from table;', $storeData);
$cache->add('select * from table;', $storeData);
$cache->add('select * from table;', $storeData);
$cache->add('select * from table;', $storeData);

print_r($storeData = $cache->get('select * from table;'));

$cache->delete('select * from table;');

print_r ($cache->get('select * from table;') ? 'exist': 'has no cache');

$cache->add('select * from table1;', 123);
$cache->add('select * from table2;', 234);
$cache->add('select * from table3;', 345);
$cache->flush();

print_r ($cache->get('select * from table3;') ? 'exist': 'has no cache');

?>