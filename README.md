# PHP File Cache #
PHP File Cache, Used to instead of memcache in Host which can not install memcache.

- one cache, one file, reduce calculate of key and value, to gain hign performaance.
- simple api to use. similar with memcache.  

## Info ##
目前git上很大一部分缓存是写到一个缓存文件，意味着：

- 无论你是读取多大的数据，都需要从磁盘`读出整个文件到内存`，然后解析，获取你要的部分数据；
- 在缓存数据很大的时候，并不能起到缓存加速网站访问的目的，同时增加磁盘的读写负荷；
- 在某一个临界点，可能会导致缓存性能比数据库还差；
- 未经过严格测试，个人预估一般网站的数据都会达到100M以上，如果每次访问需要读取100M的数据，然后解析，性能非常低效。

## Usage ##

### API ###

Similar with memcache

* `add(k, v)` save cache
* `get(k)` if false means has no cache or cache timeout
* `delete(k)` delete cache of k
* `flush()` delete all cache 

### Demo ###
    
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

## Link ##
Using with php-file-cache.

- [http://50vip.com/](http://50vip.com/ "Blog")
- [http://www.atool.org/](http://www.atool.org/ "OnlineTool")

## License ##
php-file-cache is released under the terms of the [MIT license](http://opensource.org/licenses/MIT).
