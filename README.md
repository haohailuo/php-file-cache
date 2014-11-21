# PHP File Cache #
PHP File Cache, Used to instead of memcache in Host which can not install memcache.

## Usage ##

### API ###

Similar with memcache

* add
* get
* delete
* flush

### Demo ###

```php
$cache = new FCache();
$storeData = $cache->get('select * from table;');
if (!$storeData) {
    $storeData = array(
      'time'   => time(),
      'str' => 'test',
      'int'   => 1321
    );
    $cache->add('select * from table;', $storeData);
}
print_r($storeData);

$cache->delete('select * from table;');

$cache->add('select * from table1;', 123);
$cache->add('select * from table2;', 234);
$cache->add('select * from table3;', 345);
$cache->flush();
```


## Link ##
Using with php-file-cache.

- [http://50vip.com/](http://50vip.com/ "Blog")
- [http://www.atool.org/](http://www.atool.org/ "OnlineTool")

## License ##
php-file-cache is released under the terms of the [MIT license](http://opensource.org/licenses/MIT).
