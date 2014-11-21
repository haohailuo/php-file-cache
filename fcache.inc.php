<?php
/**
  * PHP File Cache, Used to instead of memcache in Host which can not install memcache.
  * @author: hustcc
  * @contract: http://50vip.com/
  * @data 2014-11-21
  */
class FCache {
    //Path to cache folder
    public $cache_path = 'cache/';
    //Length of time to cache a file, default 1 day (in seconds)
    public $cache_time = 86400;
    //Cache file extension
    public $cache_extension = '.atool';
    
    /**
     * 构造函数
     */
    public function __construct($cache_path = 'cache/', $cache_time = 86400, $cache_exttension = '.atool') {
        $this->cache_path = $cache_path;
        $this->cache_time = $cache_time;
        $this->cache_exttension = $cache_exttension;
        if (!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0777);
        }
    }
    
    public function add($key, $value) {
        $filename = $this->_get_cache_file($key);
        //写文件，TODO 文件锁
        file_put_contents($filename, serialize($value));
    }
    
    //删除文件即可
    public function delete($key) {
        $filename = $this->_get_cache_file($key);
        unlink($filename);
    }
    
    //获取缓存
    public function get($key) {
        if ($this->_has_cache($key)) {
            $filename = $this->_get_cache_file($key);
            $value = file_get_contents($filename);
            if (empty($value)) {
                return false;
            }
            return unserialize($value);
        }
    }
    
    //删除所有的cache文件
    public function flush() {
        $fp = opendir($this->cache_path);
        while(!false == ($fn = readdir($fp))) {
            if($fn == '.' || $fn =='..') {
                continue;
            }
            unlink($this->cache_path . $fn);
        }
    }
    
    //是否存在缓存
    private function _has_cache($key) {
        $filename = $this->_get_cache_file($key);
        if(file_exists($filename) && (filemtime($filename) + $this->cache_time >= time())) {
            return true;
        }
        return false;
    }
    
    private function _is_valid_key($key) {
        if ($key != null) {
            return true;
        }
        return false;
    }
    
    private function _safe_filename($key) {
        if ($this->_is_valid_key($key)) {
            //not support chinese
            //return preg_replace('/[^0-9a-z\.\_\-]/i','', strtolower($key));
            return md5($key);
        }
        return '0eb3be2db3a534c192be5570c6c42f59atool.org';//key不合法的时候，同时缓存到该文件，md5('atool.org').'atool.org';
        
    }
    
    private function _get_cache_file($key) {
        return $this->cache_path . $this->_safe_filename($key) . $this->cache_extension;
    }
}

/*
//example
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
*/
?>