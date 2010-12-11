<?php
/**
 * rhaco 用 autoload
 *
 * @author  riaf <ksato@otobank.co.jp>
 * @license New BSD License
 * @info    http://github.com/riaf/rhaco2-repository/wiki/libs-util-AutoLoader
 **/
class AutoLoader
{
    static protected $classes = array();

    static public function __import__() {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    static public function load($name) {
        if (empty(self::$classes)) {
            self::load_classes();
        }
        if (class_exists($name, false) || interface_exists($name, false)) {
            return true;
        }
        if (isset(self::$classes[$name])) {
            import(self::$classes[$name]);
            return true;
        }
        return false;
    }

    static protected function load_classes() {
        $store_key = array(__DIR__, '__autoload');
        if (Store::has($store_key)) {
            $classes = Store::get($store_key);
        } else {
            $classes = array();
            $modules = array();
            $dir = path('libs');
            $itr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            $pattern = '/^'. preg_quote($dir, '/'). '\/(.+?)\.php$/';
            foreach ($itr as $elem) {
                if ($elem->isFile() && preg_match($pattern, $elem->getPathname(), $match)) {
                    $class_name = $elem->getBasename('.php');
                    if ($class_name == basename($elem->getPath())) {
                        $modules[$class_name] = str_replace('/', '.', substr($elem->getPath(), strlen($dir) + 1));
                    } else if ($class_name !== __CLASS__) {
                        $classes[$class_name] = str_replace('/', '.', $match[1]);
                    }
                }
            }
            foreach ($modules as $module_name => $module_path) {
                foreach ($classes as $class_name => $class_path) {
                    if (strpos($class_path, $module_path) === 0) {
                        unset($classes[$class_name]);
                    }
                }
            }
            $classes = $modules + $classes;
            Store::set($store_key, $classes);
        }
        self::$classes = $classes;
    }

    /**
     * autoload キャッシュを削除する
     **/
    static public function __setup_autoload_clear__() {
        Store::delete(array(__DIR__, '__autoload'));
    }
}

