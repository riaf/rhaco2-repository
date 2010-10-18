<?php
/**
 * Store module for APC
 *
 * @author  Keisuke SATO <ksato@otobank.co.jp>
 * @license New BSD License
 **/

class StoreAPC
{
    /**
     * Checks if APC key exists
     *
     * @param   string  $id
     * @param   int     $ignore_time
     * @return  bool
     **/
    public function store_has($id, $ignore_time=null) {
        return apc_exists($id);
    }

    /**
     * Fetch a stored variable from the cache
     *
     * @param   string  $id
     * @return  string
     **/
    public function store_get($id) {
        $result = apc_fetch($id, $success);
        return $success? $result: null;
    }

    /**
     * Cache a variable in the data store
     *
     * @param   string  $id
     * @param   string  $source
     * @param   int     $expire_time
     * @return  string  $source
     **/
    public function store_set($id, $source, $expire_time) {
        apc_store($id, $source, $expire_time);
        return $source;
    }

    /**
     * Removes a stored variable from the cache
     *
     * @param   string  $id
     * @return  void
     **/
    public function store_delete($id) {
        apc_delete($id);
    }
}

